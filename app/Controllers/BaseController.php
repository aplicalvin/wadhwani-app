<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = service('session');
        $this->session = \Config\Services::session();
    }

    /**
     * Fungsi helper untuk menangani upload gambar
     *
     * @param string $inputName - Nama input file (misal: 'image')
     * @param string $uploadPath - Path folder (misal: 'uploads/categories')
     * @param string|null $oldImageName - Nama file lama (untuk dihapus saat update)
     * @return string|null - Mengembalikan nama file baru, atau null jika gagal/tidak ada file
     */
    protected function handleImageUpload(string $inputName, string $uploadPath, string $oldImageName = null): ?string
    {
        $file = $this->request->getFile($inputName);

        // Cek apakah ada file valid yang diupload
        if ($file && $file->isValid() && !$file->hasMoved()) {
            
            // Validasi file (Opsional tapi disarankan)
            // if (!$file->isImage()) {
            //     session()->setFlashdata('error', 'File yang diupload bukan gambar.');
            //     return null;
            // }

            // Hapus gambar lama jika ada
            if ($oldImageName) {
                $oldPath = FCPATH . $uploadPath . '/' . $oldImageName;
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Pindahkan file baru
            $newName = $file->getRandomName();
            $file->move(FCPATH . $uploadPath, $newName);

            return $newName; // Kembalikan nama file baru untuk disimpan di DB
        }
        
        return null; // Tidak ada file baru yang diupload
    }

    /**
     * Fungsi helper untuk menghapus gambar saat delete
     */
    protected function deleteImage(string $uploadPath, string $imageName = null)
    {
        if ($imageName) {
            $path = FCPATH . $uploadPath . '/' . $imageName;
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
}
