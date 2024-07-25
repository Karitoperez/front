<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ArchivoLeccion extends Component
{
    use WithFileUploads;

    public $tipo;
    public $nombre;
    public $ubicacion;
    public $id_leccion;
    public $mostrarFormCrear;
    public $leccion;
    public $lecciones;
    public $usuario;

    protected $rules = [
        'nombre' => 'required|string',
        'ubicacion' => 'required|file|mimes:pdf,jpeg,png,mp4',
    ];

    protected $messages = [
        'nombre.required' => 'El nombre es requerido.',
        'nombre.string' => 'El nombre debe ser una cadena de caracteres.',
        'ubicacion.required' => 'El archivo es requerido.',
        'ubicacion.file' => 'El archivo debe ser válido.',
        'ubicacion.mimes' => 'El archivo debe ser de tipo PDF, JPEG, PNG o MP4.',
    ];

    public function render()
    {
        return view('livewire.archivo-leccion');
    }

    public function abrirModalCrear($id_leccion)
    {
        $this->id_leccion = $id_leccion;
        $this->mostrarFormCrear = true;
    }

    public function cerrarModalCrear()
    {
        $this->mostrarFormCrear = false;
        $this->id_leccion = null;
        $this->nombre = null;
        $this->ubicacion = null;

        $this->resetValidation();
    }

    public function agregarArchivo()
    {
        $this->validate();
        try {
            // Obtener la ubicación del archivo de la propiedad $ubicacion
            $archivo = $this->ubicacion;

            // Obtener la extensión del archivo
            $extension = $archivo->getClientOriginalExtension();

            // Validar y obtener el tipo de archivo
            $tipoArchivo = $this->getTipoArchivo($extension);

            // Generar un nombre único para el archivo
            $nombreArchivo = uniqid('archivo_') . '.' . $extension;

            // Guardar el archivo en el sistema de archivos con el nombre único
            $rutaArchivo = $archivo->storeAs('public/archivos', $nombreArchivo);

            // Obtener la URL pública del archivo
            $urlArchivo = Storage::url($rutaArchivo);

            // Obtén el token y el usuario de la sesión
            $token = session('token');

            // Enviar la solicitud POST a la API con los datos del formulario
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->acceptJson()->post('http://localhost:8000/api/archivo-leccion', [
                'tipo' => $tipoArchivo,
                'nombre' => $this->nombre,
                'ubicacion' => $urlArchivo,
                'id_leccion' => (int)$this->id_leccion
            ]);

            if ($response->successful()) {
                $this->leccion = $response->json("leccion");

                // Si la solicitud fue exitosa, adjunta un mensaje de éxito a la redirección
                session()->flash('success', 'Archivo agregado correctamente!');
                $this->cerrarModalCrear();
                return redirect()->back();
            } else {
                // Si la solicitud no fue exitosa, adjunta un mensaje de error a la redirección
                $error = $response->json();
                session()->flash('error', 'Error al agregar el archivo: ' . $error['message']);
                return redirect()->back();
            }
        } catch (\Exception $e) {
            // En caso de error, adjunta un mensaje de error a la redirección
            session()->flash('error', 'Error al agregar el archivo: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    private function getTipoArchivo($extension)
    {
        // Array de extensiones y sus tipos correspondientes
        $extensiones = [
            'pdf' => 'PDF',
            'jpeg' => 'Imagen',
            'png' => 'Imagen',
            'jpg' => 'Imagen',
            'mp4' => 'Video',
            // Puedes agregar más extensiones y tipos según tus necesidades
        ];

        // Verificar si la extensión está en el array
        if (array_key_exists($extension, $extensiones)) {
            return $extensiones[$extension];
        } else {
            return 'Archivo Desconocido';
        }
    }
}
