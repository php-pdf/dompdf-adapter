<?php

namespace Pdf\Adapter;

use Dompdf\Dompdf;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Stream;

class DompdfPdf implements Pdf
{

    /** @var \Pdf\Adapter\\Dompdf */
    protected $dompdf;

    /** @var string */
    protected $output;

    /**
     * @param \Dompdf\Dompdf $dompdf
     */
    public function __construct(Dompdf $dompdf)
    {
        $this->dompdf = $dompdf;
    }

    /**
     * Force the PDF to download.
     *
     * @param  string|null $filename
     * @return ResponseInterface
     */
    public function attachment($filename = null)
    {
        return $this->getResponse()
          ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Show the PDF in the browser.
     *
     * @param  string $filename
     * @return ResponseInterface
     */
    public function inline($filename = null)
    {
        return $this->getResponse()
          ->withHeader('Content-Disposition', 'inline; filename="' . $filename . '"');
    }

    /**
     * Save the PDF to a file path.
     *
     * @param  string $path
     * @return bool  true if successful
     */
    public function save($path)
    {
        return file_put_contents($path, $this->output()) > 0;
    }

    /**
     * Get the PDF as a string
     *
     * @return string
     */
    public function output()
    {
        if (!$this->output) {
            $this->dompdf->render();

            $this->output = $this->dompdf->output();
        }

        return $this->output;
    }

    /**
     * @return ResponseInterface
     */
    protected function getResponse()
    {
        $body = new Stream('php://temp', 'wb+');
        $body->write($this->output());

        return new Response($body, 200, [
          'Content-Type' => 'application/pdf',
        ]);
    }
}
