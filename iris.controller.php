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
    $activateRestoreFromFile = false;
    $classification = new \Phpml\Classification\KNearestNeighbors(3);
    $classification->train($dataset->getTrainSamples(), $dataset->getTrainLabels());

    $activateModelManager = true;
    if($activateModelManager) {
        $modelManager = new \Phpml\ModelManager();
        $modelManager->saveToFile($classification, './models/classifer');

        if($activateRestoreFromFile) {
            $classifer = $modelManager->restoreFromFile('./models/classifer');
        }
    }
    $predicted = $classification->predict($dataset->getTestSamples());

    $clustering = new \Phpml\Clustering\KMeans(3);
    $clusters   = $clustering->cluster($data->getSamples(), $dataset->getTrainLabels());    

    // Evaluating machine learning models.
    $accuracy = \Phpml\Metric\Accuracy::score($dataset->getTestLabels(), $predicted);
    echo "Accuracy is : " . $accuracy . PHP_EOL;

    // var_dump($clusters);
    $file = fopen('cluster_data.csv', 'w');
    foreach($clusters as $key => $cluster) {
        foreach($cluster as $data) {
            $dataToWrite = [...$data, $key];
            fputcsv($file, $dataToWrite);
        }
    }
    fclose($file);

    // Making predictions with trained models.

?>