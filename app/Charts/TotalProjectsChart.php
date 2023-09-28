<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class TotalProjectsChart
{
    protected $chart;
    public $title = 'set title in here';
    public $subtitle = '';
    public $data = [];
    public $label = [];


    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function setTitle(String $title)
    {
        $this->title = $title;
    }

    public function setSubtitle(String $subtitle)
    {
        $this->subtitle = $subtitle;
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function setLabel(array $label)
    {
        $this->label = $label;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        return $this->chart->pieChart()
            ->setTitle($this->title)
            ->setSubtitle($this->subtitle)
            ->addData($this->data)
            ->setFontFamily('arial')
            ->setLabels($this->label);
    }
}
