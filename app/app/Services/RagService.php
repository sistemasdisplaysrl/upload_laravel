<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RagService
{
    private $baseUrl;

    public function __construct()
    {
        // Usar la URL interna de Docker (rag-python:8000)
        $this->baseUrl = env('RAG_API_URL', 'http://rag-python:8000');
    }

    /**
     * Ingestar un PDF en el sistema RAG
     * 
     * @param string $filename Nombre del archivo (sin ruta, solo nombre)
     * @param string $docId ID único del documento
     * @param string $area Área/cargo del documento
     * @param string $version Versión del documento
     * @return array
     */
    public function ingestPdf($filename, $docId, $area, $version = '1.0')
    {
        try {
            $response = Http::timeout(60)->post("{$this->baseUrl}/ingest-pdf", [
                'pdf_path' => $filename,  // Solo el nombre del archivo
                'doc_id' => $docId,
                'area' => $area,
                'doc_version' => $version,
                'replace_existing' => true
            ]);

            if ($response->successful()) {
                Log::info("RAG: PDF ingested successfully", [
                    'filename' => $filename,
                    'doc_id' => $docId,
                    'area' => $area
                ]);
                
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            Log::error("RAG: Ingestion failed", [
                'filename' => $filename,
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return [
                'success' => false,
                'error' => $response->json() ?? $response->body()
            ];

        } catch (\Exception $e) {
            Log::error("RAG: Ingestion exception", [
                'filename' => $filename,
                'message' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Hacer una consulta al RAG
     * 
     * @param string $question Pregunta del usuario
     * @param string|null $area Filtrar por área específica
     * @return array
     */
    public function query($question, $area = null)
    {
        try {
            $payload = ['query' => $question];
            
            if ($area) {
                $payload['area'] = $area;
            }

            $response = Http::timeout(30)->post("{$this->baseUrl}/query", $payload);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'error' => $response->json() ?? $response->body()
            ];

        } catch (\Exception $e) {
            Log::error("RAG: Query exception", [
                'question' => $question,
                'message' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
