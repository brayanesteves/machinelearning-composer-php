<?php
    require "vendor/autoload.php";

    // Loading the data.
    $data = new \Phpml\Dataset\CsvDataset('./data/iris.csv', 4, true);

    // Preprocessing data.
    $dataset = new \Phpml\CrossValidation\StratifiedRandomSplit($data, 0.2, 156);
    // $dataset->getTrainSamples();
    // $dataset->getTrainLabels();
    // $dataset->getTestSamples();
    // $dataset->getTestLabels();

    // Training.
    // Regression with 'SVR'.
    $classification = new \Phpml\Classification\KNearestNeighbors(3);
    $classification->train($dataset->getTrainSamples(), $dataset->getTrainLabels());
    $predicted = $classification->predict($dataset->getTestSamples());

    // Evaluating machine learning models.
    
    $accuracy = \Phpml\Metric\Accuracy::score($dataset->getTestLabels(), $predicted);
    echo "Accuracy is : " . $accuracy . PHP_EOL;

    // Making predictions with trained models.

?>