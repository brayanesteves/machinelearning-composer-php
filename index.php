<?php
    require "vendor/autoload.php";

    // Loading the data.
    $data = new \Phpml\Dataset\CsvDataset('./data/insurance.csv', 1, true);

    // Preprocessing data.
    $dataset = new \Phpml\CrossValidation\RandomSplit($data, 0.2, 156);
    $dataset->getTrainSamples();
    $dataset->getTrainLabels();
    $dataset->getTestSamples();
    $dataset->getTestLabels();

    // Training.
    // Linear Regression.
    $regression = new \Phpml\Regression\LeastSquares();
    $regression->train($dataset->getTrainSamples(), $dataset->getTrainLabels());
    $predict = $regression->predict($dataset->getTestSamples());

    // Evaluating machine learning models.
    $score = \Phpml\Metric\Regression::r2Score($dataset->getTestLabels(), $predict);
    echo "r2score is : " . $score;

    // Making predictions with trained models.
    var_dump($regression->predict($dataset->getTestSamples()));

?>