<?php

namespace App\Http\Controllers;

use App\Models\Manual;
use App\Models\Cargo;
use App\Services\RagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ManualController extends Controller
{
    protected $ragService;

    public function __construct(RagService $ragService)
    {
        $this->ragService = $ragService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = trim((string) $request->input('buscar'));

        $manuales = Manual::with('cargo')
            ->when($buscar, function ($q) use ($buscar) {
                $q->where(function ($q) use ($buscar) {
                    $q->where('nombre', 'like', "%$buscar%")
                      ->orWhere('version', 'like', "%$buscar%")
                      ->orWhere('estado', 'like', "%$buscar%")
                      ->orWhereHas('cargo', function ($cq) use ($buscar) {
                          $cq->where('cargo', 'like', "%$buscar%");
                      });
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->appends(['buscar' => $buscar]);

        return view('admin.manuales.index', compact('manuales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cargos = Cargo::orderBy('cargo')->get();
        $maxByCargo = Manual::selectRaw('cargo_id, MAX(version) as v')->groupBy('cargo_id')->pluck('v', 'cargo_id');
        $nextByCargo = [];
        foreach ($cargos as $c) {
            $current = (int) ($maxByCargo[$c->id] ?? 0);
            $nextByCargo[$c->id] = $current + 1;
        }
        return view('admin.manuales.create', compact('cargos', 'nextByCargo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cargo_id' => 'required|exists:cargos,id',
            'nombre' => 'required|string|max:255',
            'archivo' => 'required|file|mimes:pdf|max:10240',
        ]);

        DB::transaction(function () use ($request) {
            $cargoId = (int) $request->cargo_id;

            $nextVersion = (int) (Manual::where('cargo_id', $cargoId)->max('version') ?? 0) + 1;

            $file = $request->file('archivo');
            $safeName = preg_replace('/[^A-Za-z0-9_-]+/', '_', strtolower(pathinfo($request->nombre, PATHINFO_FILENAME)));
            $filename = $safeName . '_V' . $nextVersion . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->makeDirectory('manuales');
            Storage::disk('public')->putFileAs('manuales', $file, $filename);
            Storage::disk('public')->setVisibility('manuales/' . $filename, 'public');

            Manual::where('cargo_id', $cargoId)->update(['estado' => 'NO VIGENTE']);

            $manual = Manual::create([
                'cargo_id' => $cargoId,
                'nombre' => strtoupper($request->nombre),
                'version' => $nextVersion,
                'archivo' => $filename,
                'estado' => 'VIGENTE',
            ]);

            // Ingestar en RAG
            $cargo = Cargo::find($cargoId);
            $docId = 'manual-' . $cargo->id . '-v' . $nextVersion;
            
            $ragResult = $this->ragService->ingestPdf(
                $filename,
                $docId,
                $cargo->cargo,
                (string) $nextVersion
            );

            if (!$ragResult['success']) {
                Log::warning('RAG ingestion failed but manual was saved', [
                    'manual_id' => $manual->id,
                    'error' => $ragResult['error']
                ]);
            }
        });

        return redirect()->route('admin.manuales.index')
            ->with('mensaje', 'Manual registrado exitosamente')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Manual $manual)
    {
        return view('admin.manuales.show', compact('manual'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manual $manual)
    {
        $cargos = Cargo::orderBy('cargo')->get();
        return view('admin.manuales.edit', compact('manual', 'cargos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manual $manual)
    {
        $request->validate([
            'cargo_id' => 'required|exists:cargos,id',
            'nombre' => 'required|string|max:255',
            'archivo' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        DB::transaction(function () use ($request, $manual) {
            $cargoId = (int) $request->cargo_id;

            $manual->cargo_id = $cargoId;
            $manual->nombre = strtoupper($request->nombre);

            if ($request->hasFile('archivo')) {
                if ($manual->archivo && Storage::exists('public/manuales/' . $manual->archivo)) {
                    Storage::delete('public/manuales/' . $manual->archivo);
                }
                $file = $request->file('archivo');
                $safeName = preg_replace('/[^A-Za-z0-9_-]+/', '_', strtolower(pathinfo($request->nombre, PATHINFO_FILENAME)));
                $filename = $safeName . '_V' . $manual->version . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->makeDirectory('manuales');
                Storage::disk('public')->putFileAs('manuales', $file, $filename);
                Storage::disk('public')->setVisibility('manuales/' . $filename, 'public');
                $manual->archivo = $filename;
                
                // Ingestar en RAG si se actualizó el archivo
                $cargo = Cargo::find($cargoId);
                $docId = 'manual-' . $cargo->id . '-v' . $manual->version;
                
                $ragResult = $this->ragService->ingestPdf(
                    $filename,
                    $docId,
                    $cargo->cargo,
                    (string) $manual->version
                );

                if (!$ragResult['success']) {
                    Log::warning('RAG ingestion failed but manual was updated', [
                        'manual_id' => $manual->id,
                        'error' => $ragResult['error']
                    ]);
                }
            }

            $manual->save();
        });

        return redirect()->route('admin.manuales.index')
            ->with('mensaje', 'Manual actualizado exitosamente')
            ->with('icono', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manual $manual)
    {
        DB::transaction(function () use ($manual) {
            if ($manual->archivo && Storage::disk('public')->exists('manuales/' . $manual->archivo)) {
                Storage::disk('public')->delete('manuales/' . $manual->archivo);
            }
            $cargoId = $manual->cargo_id;
            $manual->delete();

            $ultimo = Manual::where('cargo_id', $cargoId)->orderByDesc('version')->first();
            if ($ultimo) {
                Manual::where('cargo_id', $cargoId)->update(['estado' => 'NO VIGENTE']);
                $ultimo->estado = 'VIGENTE';
                $ultimo->save();
            }
        });

        return redirect()->route('admin.manuales.index')
            ->with('mensaje', 'Manual eliminado exitosamente')
            ->with('icono', 'success');
    }
}

