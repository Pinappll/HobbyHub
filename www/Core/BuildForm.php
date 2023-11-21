<?php

namespace App\Core;

class BuildForm
{
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function generateForm(): string
    {
        $html = '<form';

        // Add form attributes
        foreach ($this->config['config'] as $attribute => $value) {
            $html .= ' ' . $attribute . '="' . $value . '"';
        }

        $html .= '>';

        // Add form inputs
        foreach ($this->config['inputs'] as $inputName => $inputAttributes) {
            $html .= $this->generateInput($inputName, $inputAttributes);
        }

        $html .= '<button type="submit">' . $this->config['config']['submit'] . '</button>';
        $html .= '</form>';

        return $html;
    }

    private function generateInput($name, $attributes): string
    {
        $inputHtml = '<div>';
        $inputHtml .= '<label for="' . $name . '">' . ucfirst($name) . ':</label>';

        //Add input attributes
        $inputHtml .= '<input';
        foreach ($attributes as $attribute => $value) {
            if ($attribute !== 'confirm') {
                $inputHtml .= ' ' . $attribute . '="' . $value . '"';
            }
        }

        $inputHtml .= '>';
        $inputHtml .= '</div>';

        return $inputHtml;
    }
}


