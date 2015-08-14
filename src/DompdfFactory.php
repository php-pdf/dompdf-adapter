<?php

namespace Pdf\Adapter;

use Dompdf\Dompdf;

class DompdfFactory implements Factory
{

    /** @var  array */
    protected $options;

    /**
     * Set the default options
     *
     * @param  array $options
     * @return void
     */
    public function setDefaultOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * Create the PDF from a HTML string
     *
     * @param  string $html
     * @param  array $options
     * @return Pdf The Pdf instance
     */
    public function html($html, array $options = [])
    {
        $dompdf = $this->makeDompdf($options);

        $dompdf->loadHtml($html);

        return new DompdfPdf($dompdf);
    }

    /**
     * Create the PDF from an existing HTML file
     *
     * @param  string $path
     * @param  array $options
     * @return Pdf The Pdf instance
     */
    public function file($path, array $options = [])
    {
        $dompdf = $this->makeDompdf($options);

        $dompdf->loadHtmlFile($path);

        return new DompdfPdf($dompdf);
    }

    /**
     * Get a fresh dompdf instance
     *
     * @param  array $options
     * @return Dompdf The dompdf instance
     */
    protected function makeDompdf(array $options)
    {
        $dompdf = new Dompdf();

        $options = $options + $this->options;

        if (isset($options['paper'])) {
            $paper = $options['paper'];
        } else {
            $paper = 'a4';
        }

        if (isset($options['orientation'])) {
            $orientation = $options['orientation'];
        } else {
            $orientation = 'portrait';
        }

        $dompdf->setPaper($paper, $orientation);

        return $dompdf;
    }
}
