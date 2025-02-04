<?php
    require "vendor/autoload.php";

    // Loading the data.
    $data = new \Phpml\Dataset\CsvDataset('./data/wine.csv', 13, true);

    // Preprocessing data.
    $dataset = new \Phpml\CrossValidation\StratifiedRandomSplit($data, 0.2, 156);
    // $dataset->getTrainSamples();
    // $dataset->getTrainLabels();
    // $dataset->getTestSamples();
    // $dataset->getTestLabels();

    // Training.
    // Regression with 'SVR'.
    $regression = new \Phpml\Regression\SVR();
    $regression->train($dataset->getTrainSamples(), $dataset->getTrainLabels());
    $predicted = $regression->predict($dataset->getTestSamples());

    // Evaluating machine learn9ing models.
    $score = \Phpml\Metric\Regression::r2Score($dataset->getTestLabels(), $predicted);
    echo "r2score is : " . $score . PHP_EOL;

    foreach($predicted as &$target) {
        $target = round($target, 0);
    }
    $accuracy = \Phpml\Metric\Accuracy::score($dataset->getTestLabels(), $predicted);
    echo "Accuracy is : " . $accuracy . PHP_EOL;

    // Making predictions with trained models.

?>