<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->registerJsFile("@web/js/main.js",[
    'depends' => [
        \frontend\assets\AppAsset::className()
    ]
]);

$this->title = "Scan Agent Referal QrCode";
?>
                <div class="panel-heading text-center" style="margin-top:40px;">
                	<h2 style="font-family:'Myriad Pro Regular';font-weight:normal;font-size:20px;"><?=$this->title ?></h2>
                    <div class="navbar-form navbar-right">
                        <select class="form-control" id="camera-select"></select>
                        <div class="form-group" style="margin-top: 20px;">
                            <button title="Decode Image" class="btn btn-default d-none btn-sm" id="decode-img" type="button" data-toggle="tooltip"><span class="glyphicon glyphicon-upload"></span></button>
                            <button title="Image shoot" class="btn btn-info d-none btn-sm disabled" id="grab-img" type="button" data-toggle="tooltip"><span class="glyphicon glyphicon-picture"></span></button>
                            <button title="Play" class="btn btn-success btn-md" id="play" type="button" data-toggle="tooltip" style="width:100px;font-family:'Myriad Pro Regular';font-weight:normal;font-size:16px;"><span class="glyphicon glyphicon-qrcode"></span> Scan</button>
                            <button title="Pause" class="btn btn-warning d-none btn-md" id="pause" type="button" data-toggle="tooltip"><span class="glyphicon glyphicon-pause"></span></button>
                            <button title="Stop streams" class="btn btn-danger btn-md" id="stop" type="button" data-toggle="tooltip" style="width:100px;font-family:'Myriad Pro Regular';font-weight:normal;font-size:16px;"><span class="glyphicon glyphicon-stop"></span> Stop</button>
							<a href="./manual"><button title="Input Manual" class="btn btn-warning btn-md" id="manual" type="button" data-toggle="tooltip" style="width:100px;background-color:blue;font-family:'Myriad Pro Regular';font-weight:normal;font-size:16px;"><span class="glyphicon glyphicon-edit"></span> Manual</button></a>
                            <?php //echo Html::a("<button title='Input Manual' class='btn btn-danger btn-md' id='manual' type='button' data-toggle='tooltip' style='width:100px;background-color:blue'><span class='glyphicon glyphicon-stop'></span> Input Manual</button>, ['otp'], ['class' => 'btn btn-complete btn-animated from-left pg pg-plus']");?>
							
                         </div>
                    </div>
                </div>
                <div class="panel-body text-center">
                    <div class="col-md-12">
                        <div class="well" style="position: relative;display: inline-block;">
                            <canvas style="max-width: 100%" width="320" height="240" id="webcodecam-canvas"></canvas>
                            <div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
                            <div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
                            <div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
                            <div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
                        </div>
                        <div class="well" style="width: 100%;display:none;">
                        	<div class="row">
                        		<div class="col-6">
		                            <label id="zoom-value" width="100">Zoom: 2</label>
		                            <input id="zoom" onchange="Page.changeZoom();" type="range" min="10" max="30" value="10"><br>
		                            <label id="brightness-value" width="100">Brightness: 0</label>
		                            <input id="brightness" onchange="Page.changeBrightness();" type="range" min="0" max="128" value="0"><br>
		                            <label id="contrast-value" width="100">Contrast: 0</label>
		                            <input id="contrast" onchange="Page.changeContrast();" type="range" min="0" max="64" value="0"><br>
		                            <label id="threshold-value" width="100">Threshold: 0</label>
		                            <input id="threshold" onchange="Page.changeThreshold();" type="range" min="0" max="512" value="0"><br>
		                        </div>
	                        
		                        <div class="col-6">
		                            <label id="sharpness-value" width="100">Sharpness: off</label>
		                            <input id="sharpness" onchange="Page.changeSharpness();" type="checkbox"><br>
		                            <label id="grayscale-value" width="100">grayscale: off</label>
		                            <input id="grayscale" onchange="Page.changeGrayscale();" type="checkbox"><br>
		                            <label id="flipVertical-value" width="100">Flip Vertical: off</label>
		                            <input id="flipVertical" onchange="Page.changeVertical();" type="checkbox"><br>
		                            <label id="flipHorizontal-value" width="100">Flip Horizontal: off</label>
		                            <input id="flipHorizontal" onchange="Page.changeHorizontal();" type="checkbox">
		                        </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="thumbnail" id="result">
                            <div class="well d-none" style="overflow: hidden;">
                                <img width="320" height="240" id="scanned-img" src="" >
                            </div>
                            <div class="caption text-danger">
                                <h3 style="font-size:9px;font-family:arial;color:white;">Scanned result</h3>
                                <p id="scanned-QR" style="font-size:10px;font-family:arial;color:white;"></p>
                            </div>
                        </div>
                    </div>
                </div>

<?php 
$script = <<< JS

JS;
$this->registerJs($script);
?>