<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Questions;
use common\models\QuestionsOption;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;

use Yii as Yii;

$getUrlWeb = Yii::$app->generalFunction->getUrlWeb();


/* @var $this yii\web\View */
$this->title = Yii::$app->generalFunction->getSetting('title');

?>
<style>
.row{
	font-size:14px;
	font-family:'Myriad Pro Regular';
	font-weight:normal;
}

.form-control{
	font-size:14px;
	font-family:'Myriad Pro Regular';
	font-weight:normal;
	text-transform: uppercase;
	box-shadow: 10px 10px 5px -6px rgba(0,0,0,0.21);
-webkit-box-shadow: 10px 10px 5px -6px rgba(0,0,0,0.21);
-moz-box-shadow: 10px 10px 5px -6px rgba(0,0,0,0.21);
}

/* The container */
.containerss {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 14px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.containerss input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

.containerssc {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 14px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.containerssc input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #eee;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #d54e21;
  content: "\2713";
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container .checkmark:after {
 	top: 0px;
	left: 5px;
	width: 6px;
	height: 6px;
    content: "\2713";
    color: white;
    font-size:15px;
    font-weight:bold;
}



/* Create a custom checkbutton */
.checkmarkc {
  position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #eee;
  border-radius: 5%;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmarkc {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container input:checked ~ .checkmarkc {
  background-color: #d54e21;
  content: "\2713";
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmarkc:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container input:checked ~ .checkmarkc:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container .checkmarkc:after {
 	top: 0px;
	left: 5px;
	width: 6px;
	height: 6px;
    content: "\2713";
    color: white;
    font-size:15px;
    font-weight:bold;
}


.categoryname{
	font-size:16px;
	font-weight:bold;
	text-align:left;
	padding-left:10px;
	white-space: normal;
	margin-bottom:20px;
	background-color:#ec1b24;
	color:white;
	height:30px;
	padding-top:5px;
	/*-webkit-border-top-right-radius: 40px;-moz-border-radius-topright: 40px;border-top-right-radius: 40px;*/
}



/* DivTable.com */
.divTable{
	display: table;
	width: 100%;
}
.divTableRow {
	display: table-row;
	width: 100%;
}
.divTableHeading {
	background-color: #EEE;
	display: table-header-group;
}
.divTableCell, .divTableHead {
	border: 1px solid #999999;
	display: table-cell;
	padding: 3px 10px;
  max-width:30%;
}
.divTableHeading {
	background-color: #EEE;
	display: table-header-group;
	font-weight: bold;
}
.divTableFoot {
	background-color: #EEE;
	display: table-footer-group;
	font-weight: bold;
}
.divTableBody {
	display: table-row-group;
}

.qq-uploader{
	position: relative;
    min-height: 120px;
    max-height: 130px;
    overflow-y: hidden;
    width: inherit;
    border-radius: 6px;
    background-color: #fdfdfd;
    border: 1px dashed #ccc;
    padding: 10px;
}

.linghenam :before :hover{
	color:#B0C3FF;
	font-family:'Myriad Pro Regular';
	text-decoration: none;
}
.linghenam :after :active{
	color:black;
	text-decoration: none;
}

a{color:#428bca;text-decoration:none;}
a:hover,a:focus{color:#2a6496;text-decoration:none;}
a:current{color:black;}


.error{
	color: red;
	font-style: italic;
	font-family:'Myriad Pro Regular';
	font-size: 12px;
}
</style>
<div class="clearfix" style="margin-bottom:50px;"></div>
<div class="app-content container">
<!-- Form wizard with vertical tabs section start -->
<section id="number-tabs" style="z-index:300;">
	<div class="row">
		<div class="col-12" style="z-index: 2;">
			<div class="card"  style="z-index: 50;">
				<div class="card-header">
					 <div class="col-md-12" style="margin-top:20px;text-align:center;">
						<img class="duoooll" src="../images/backgrounds/duologos.png" alt="Image description"/>
					</div>
		
				</div>
				
			
				<div class="card-content collapse show" style="padding-bottom:170px;">
					<div class="card-body">
						<?php $form = ActiveForm::begin(['id' => 'questionaire-form', 'method' => 'post', 'action'=>['site/send-form'], 'options'=>['enctype'=>"multipart/form-data", 'class'=>'steps-validation wizard-circle']]); ?>
						
						<?php 
						foreach($category as $key=>$item):  ?>
						<h6 style="text-align:left;">
							<div style="color:#727D9F;padding-top:10px;font-size:12px;font-family:'Myriad Pro Bold';font-weight:normal;text-align:center;padding-left:5px;white-space: normal;letter-spacing:0.75px;">&nbsp;<?php echo $item->category_title ?></div>
						</h6>
							<fieldset>
								<div class="row foorm" style="text-align:left;">
									<div class="col-lg-12 form-rom" style="">
										<div class="categoryname"><?php echo $item->category_name; ?></div>
										<?php echo $item->text_1 ?>
									</div>
									<?php
									$listForm = Questions::find()->where(['category_id'=>$item->id])->orderBy('sort_order asc')->all();
									
									foreach($listForm as $key2=>$question):

									//JIKA MENGGUNAKAN LAYOUT GENERAL
										if($item->custom=='0'){
											?>
											<div class="col-md-12" style="border-top:solid 1px #F6F6F6;padding-top:5px;padding-bottom:5px;border-width:90%;">
												<?php if($question->question_type == "RADIO"){ ?>
												<div style="width: 100%" class="form-group">
															<div class="col-md-4" style="float:left;margin-top:5px;padding-left:15px;">
																<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
															</div>
															<div class="col-md-8" style="float:left;margin-top:5px;">
																<?php 
																$questionOption = QuestionsOption::find()->where(['question_id'=>$question->id])->all();
																foreach ($questionOption as $key3 => $option):
																	?>
																	<div style="float:left;position:relative;width:70%">
																		<label class="containerss" for="input-<?=$question->input_name ?>-<?=$key3 ?>" ><?=$option->option_text ?>
																		  <input type="radio" value="<?=$option->point_value ?>" name="<?=$question->input_name ?>" id="input-<?=$question->input_name ?>-<?=$key3 ?>" class="<?=$option->other_answer==1? 'bukaindong':'tutupindong' ?>"  data-buka="<?php echo $option->other_answer_name;?>" >
																		  <span class="checkmark"></span>
																		</label>
																	</div>
																	
																	<?php 
																	if($option->other_answer=='1'){
																	?>
																	<div style="float:left;position:relative;width:70%;"  >
																		<input type="text" class="form-control"  name="<?php echo $option->other_answer_name;?>" id="<?php echo $option->other_answer_name;?>" autocomplete="OFF" style="display:none;">
																		
																	</div>
																	<?php } ?>
																<?php endforeach; ?>
																
															</div>

														</div>
														
														
												<?php }else if($question->question_type == "CHECKBOX"){ ?>
														<div style="width: 100%" class="form-group">
															<div class="col-md-4" style="float:left;margin-top:5px;padding-left:30px;">
																<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
															</div>
															<div class="col-md-8" style="float:left;margin-top:5px;">
																<?php 
																$questionOption = QuestionsOption::find()->where(['question_id'=>$question->id])->all();
																foreach ($questionOption as $key3 => $option):
																	?>
																	<div style="float:left;position:relative;<?=$question->n_width=='70' ? 'width:70%' : 'width:30%;' ;?>">
																		<label class="containerssc"  for="input-<?=$question->input_name ?>-<?=$key3 ?>"><?=$option->option_text ?>
																			<input type="checkbox"  class="<?=$option->other_answer==1? 'bukaindong':'tutupindong'; ?> <?=$question->is_required==1? 'required':'' ?>" data-buka="<?php echo $option->other_answer_name;?>"   value="<?=$option->point_value ?>" name="<?=$question->input_name ?>[]" id="input-<?=$question->input_name ?>-<?=$key3 ?>">
																			<span class="checkmarkc"></span>
																		</label>
																	</div>
																	
																	<?php 
																	if($option->other_answer=='1'){
																	?>
																	<div style="float:left;position:relative;<?=$question->n_width=='70' ? 'width:70%' : 'width:30%;' ;?>;"  >
																		<input type="text" class="form-control"  name="<?php echo $option->other_answer_name;?>" id="<?php echo $option->other_answer_name;?>" autocomplete="OFF" style="display:none;">
																		
																	</div>
																	<?php } ?>
																<?php endforeach; ?>
															</div>
														</div>
												<?php }else if($question->question_type == "CHECKBOX_DOMISILI_TERTANGGUNG"){ ?>
													<div class="row skin skin-square">
														<div style="width: 100%" class="form-group">
															<div class="col-md-12" style="float:left;margin-top:5px;padding-left:30px;" onclick="hh_t()">
																	<font color="red">Klik di <a><b>sini</b></font></a> jika Alamat Domisili sama dengan Alamat Identitas																	
															</div>
														</div>
													</div>
												<?php }else if($question->question_type == "CHECKBOX_DOMISILI"){ ?>
													<div class="row skin skin-square">
														<div style="width: 100%" class="form-group">
															<div class="col-md-12" style="float:left;margin-top:5px;padding-left:30px;" onclick="hh()">
																	<font color="red">Klik di <a><b>sini</b></font></a> jika Alamat Domisili sama dengan Alamat Identitas																	
															</div>
														</div>
													</div>
												<?php }else if($question->question_type == "COMBOBOX"){ ?>
													<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
															<select class="custom-select form-control <?=$question->is_required==1? 'required':'' ?>" id="<?=$question->input_name ?>" name="<?=$question->input_name ?>">
																<option value="">Select </option>
																<?php 
																$questionOption = QuestionsOption::find()->where(['question_id'=>$question->id])->all();
																foreach ($questionOption as $key3 => $option):
																	?>
																	<option value="<?=$option->point_value ?>"><?=$option->option_text ?></option>
																<?php endforeach; ?>
															</select>
														</div>
													</div>
												<?php }else if($question->question_type == "TEXTAREA"){ ?>
													<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
															<textarea name="<?=$question->input_name ?>" id="<?=$question->input_name ?>" rows="4" class="form-control <?=$question->is_required==1? 'required':'' ?>"></textarea>
														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT"){ ?>
													<div class="form-group">
														<!-- <div class="row"> -->
														<?php if($question->children_of == null || $question->children_of == '0' ){?>
															<div class="col-md-4" style="float:left;margin-top:5px;">
																<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
															</div>
															<div class="col-md-8" style="float:left;margin-top:5px;">
															<?php if($question->tipe=='number'){?>
																<input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  class="form-control <?=$question->is_required==1? 'required':'' ?>" name="<?=$question->input_name ?>" <?=$question->maxlength<>'' ? 'maxlength=' . $question->maxlength : '';?> id="<?=$question->input_name ?>" autocomplete="OFF">
															<?php }else{ ?>
																<input type="text" class="form-control <?=$question->is_required==1? 'required':'' ?>" name="<?=$question->input_name ?>" <?=$question->maxlength<>'' ? 'maxlength=' . $question->maxlength : '';?> id="<?=$question->input_name ?>" autocomplete="OFF">
															<?php } ?>
															</div>
														<?php }else{ ?>
															<div class="col-md-4" style="float:left;margin-top:5px;">&nbsp;</div>
															<div class="col-md-8" style="float:left;margin-top:5px;">
																<div class="row">
																	<div class="col-sm-3" style="float:left;">
																		<span style="color:#febc10;">&#8627; </span><label for="<?=$question->input_name ?>" style="font-weight:bold;color:#013d79;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger" style="font-size:9px;">*</span></label>':'' ?></label>
																	</div>
																	<div class="col-sm-<?=$question->n_width;?>" style="float:left;">
																		<?php if($question->tipe=='number'){?>
																			<input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  class="form-control <?=$question->is_required==1? 'required':'' ?>" name="<?=$question->input_name ?>" <?=$question->maxlength<>'' ? 'maxlength=' . $question->maxlength : '';?> id="<?=$question->input_name ?>" autocomplete="OFF">
																		<?php }else{ ?>
																			<input type="text" class="form-control <?=$question->is_required==1? 'required':'' ?>" name="<?=$question->input_name ?>" <?=$question->maxlength<>'' ? 'maxlength=' . $question->maxlength : '';?> id="<?=$question->input_name ?>" autocomplete="OFF">
																		<?php } ?>
																	</div>
																</div>
															</div>
														<?php } ?>
													<!-- </div> -->
													</div>
												<?php }else if($question->question_type == "FILEUPLOAD"){ ?>
													<div class="form-group">
														<div class="col-md-12" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
															<!--
															<input type="text" class="form-control required" name="<?=$question->input_name ?>_uploadName"  id="<?=$question->input_name ?>_uploadName" readonly>
															<input type="hidden" class="form-control <?=$question->is_required==1? 'required':'' ?>" name="<?=$question->input_name ?>" id="<?=$question->input_name ?>" autocomplete="OFF">
															-->
															<input type="text" class="form-control" name="<?=$question->input_name ?>_uploadName"  id="<?=$question->input_name ?>_uploadName" readonly>
															<input type="hidden" class="form-control <?=$question->is_required==1? '':'' ?>" name="<?=$question->input_name ?>" id="<?=$question->input_name ?>" autocomplete="OFF">
														</div>
														<div class="col-md-12" style="float:left;margin-top:5px;">
															<div class="custom-file">
																
																
																<?= powerkernel\fineuploader\Fineuploader::widget([
																'options' => [
																	'request' => [
																		'endpoint' => \yii\helpers\Url::to(['/upload/send']),
																		'params' => [Yii::$app->request->csrfParam => Yii::$app->request->csrfToken]
																	],
																	'validation' => [
																		'allowedExtensions' => ['jpeg', 'jpg', 'png', 'bmp', 'gif'],
																	],
																	'classes' => [
																		'success' => 'alert alert-success hidden',
																		'fail' => 'alert alert-error'
																	],
																	// other options like
																	'multiple'=>false,
																	// 'autoUpload'=>false
																],
																'events' => [
																		'allComplete' => '$("#loading").modal("hide"); ',
																		'complete'=> "$('#".$question->input_name."').val('files/'+responseJSON.uuid + '/' + responseJSON.uploadName);$('#".$question->input_name."_uploadName').val(responseJSON.uploadName);",
																]
															])
															?>
															</div>
														</div>
													</div>
												<?php }else if($question->question_type == "DATEPICKER"){ ?>
													<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
															<input type="date" class="form-control <?=$question->is_required==1? 'required':'' ?>" name="<?=$question->input_name ?>" id="<?=$question->input_name ?>" style="max-width:170px;font-size:14px;" maxlength="10">
														</div>
													</div>
													
													
					
												<?php }else if($question->question_type == "TEXTINPUT_OPT"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														
															
															<?php
															echo Select2::widget([
																'name' => 'provinsi',
																'data' => 
																ArrayHelper::map($prov, 'name', 'name'),
																'options' => [
																	'placeholder' => 'Pilih Provinsi ...',
																	'multiple' => false,
																	'allowClear' => true,
																	'id' => 'provinsi'
																],
															]);
															
															?>
														</div>
													</div>
												<?php } else if($question->question_type == "TEXTINPUT_OPT_DOMISILI"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														
															
															<?php
															echo Select2::widget([
																'name' => 'provinsiDomisili',
																'data' => 
																ArrayHelper::map($prov, 'name', 'name'),
																'options' => [
																	'placeholder' => 'Pilih Provinsi ...',
																	'multiple' => false,
																	'allowClear' => true,
																	'id' => 'provinsiDomisili'
																],
															]);
															
															?>
														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT_OPT_INSTITUSI"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														
															
															<?php
															echo Select2::widget([
																'name' => 'provinsiInstitusi',
																'data' => 
																ArrayHelper::map($prov, 'name', 'name'),
																'options' => [
																	'placeholder' => 'Pilih Provinsi ...',
																	'multiple' => false,
																	'allowClear' => true,
																	'id' => 'provinsiInstitusi'
																],
															]);
															
															?>
														</div>
													</div>
												<?php } else if($question->question_type == "TEXTINPUT_OPT_T"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														
															
															<?php
															echo Select2::widget([
																'name' => 'ProvinsiTertanggung',
																'data' => 
																ArrayHelper::map($prov, 'name', 'name'),
																'options' => [
																	'placeholder' => 'Pilih Provinsi ...',
																	'multiple' => false,
																	'allowClear' => true,
																	'id' => 'provinsiTertanggung'
																],
															]);
															
															?>
														</div>
													</div>
												<?php } else if($question->question_type == "TEXTINPUT_OPT_T_DOMISILI"){?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														
															
															<?php
															echo Select2::widget([
																'name' => 'provinsiDomisiliTertanggung',
																'data' => 
																ArrayHelper::map($prov, 'name', 'name'),
																'options' => [
																	'placeholder' => 'Pilih Provinsi ...',
																	'multiple' => false,
																	'allowClear' => true,
																	'id' => 'provinsiDomisiliTertanggung'
																],
															]);
															
															?>
														</div>
													</div>
												<?php } else if($question->question_type == "TEXTINPUT_OPT_T_INSTITUSI"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														
															
															<?php
															echo Select2::widget([
																'name' => 'provinsiInstitusiTertanggung',
																'data' => 
																ArrayHelper::map($prov, 'name', 'name'),
																'options' => [
																	'placeholder' => 'Pilih Provinsi ...',
																	'multiple' => false,
																	'allowClear' => true,
																	'id' => 'provinsiInstitusiTertanggung'
																],
															]);
															
															?>
														</div>
													</div>
												<?php } else if($question->question_type == "TEXTINPUT_KOTA"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														<?php
															echo Select2::widget([
															'name' => 'kota',
															'options' => [
																'id' => 'kota',
																'placeholder' => 'Pilih Kota ...',
																'multiple' => false,
																'allowClear' => true,
																'options' => [
																		'' => ['disabled' => false],
																	]
															],
														]);
															
															?>
															
															
														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT_KOTA_DOMISILI"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														<?php
															echo Select2::widget([
															'name' => 'kotaDomisili',
															'options' => [
																'id' => 'kotaDomisili',
																'placeholder' => 'Pilih Kota ...',
																'multiple' => false,
																'allowClear' => true,
															],
														]);
															
															?>
															
															
														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT_KOTA_INSTITUSI"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														<?php
															echo Select2::widget([
															'name' => 'kotaInstitusi',
															'options' => [
																'id' => 'kotaInstitusi',
																'placeholder' => 'Pilih Kota ...',
																'multiple' => false,
																'allowClear' => true,
															],
														]);
															
															?>
															
															
														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT_KOTA_T"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														<?php
															echo Select2::widget([
															'name' => 'KotaTertanggung',
															'options' => [
																'id' => 'kotaTertanggung',
																'placeholder' => 'Pilih Kota ...',
																'multiple' => false,
																'allowClear' => true,
															],
														]);
															
															?>
															
															
														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT_KOTA_T_DOMISILI"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														<?php
															echo Select2::widget([
															'name' => 'kotaDomisiliTertanggung',
															'options' => [
																'id' => 'kotaDomisiliTertanggung',
																'placeholder' => 'Pilih Kota ...',
																'multiple' => false,
																'allowClear' => true,
															],
														]);
															
															?>
															
															
														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT_KOTA_T_INSTITUSI"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														<?php
															echo Select2::widget([
															'name' => 'kotaInstitusiTertanggung',
															'options' => [
																'id' => 'kotaInstitusiTertanggung',
																'placeholder' => 'Pilih Kota ...',
																'multiple' => false,
																'allowClear' => true,
															],
														]);
															
															?>
															
															
														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT_KECAMATAN"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														<?php
															echo Select2::widget([
															'name' => 'kecamatan',
															'options' => [
																'id' => 'kecamatan',
																'placeholder' => 'Pilih Kecamatan ...',
																'allowClear' => true,
																'options' => [
																		'' => ['disabled' => false],
																	]
															],
														]);
															
															?>
															
															
														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT_KECAMATAN_DOMISILI"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														<?php
															echo Select2::widget([
															'name' => 'kecamatanDomisili',
															'options' => [
																'id' => 'kecamatanDomisili',
																'placeholder' => 'Pilih Kecamatan ...',
																'allowClear' => true,
															],
														]);
															
															?>
															
															
														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT_KECAMATAN_INSTITUSI"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														<?php
															echo Select2::widget([
															'name' => 'kecamatanInstitusi',
															'options' => [
																'id' => 'kecamatanInstitusi',
																'placeholder' => 'Pilih Kecamatan ...',
																'allowClear' => true,
															],
														]);
															
															?>
															
															
														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT_KECAMATAN_T"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														<?php
															echo Select2::widget([
															'name' => 'KecamatanTertanggung',
															'options' => [
																'id' => 'kecamatanTertanggung',
																'placeholder' => 'Pilih Kecamatan ...',
																'allowClear' => true,
																'options' => [
																		'' => ['disabled' => false],
																	]
															],
														]);
															
															?>
															
															
														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT_KECAMATAN_T_DOMISILI"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														<?php
															echo Select2::widget([
															'name' => 'kecamatanDomisiliTertanggung',
															'options' => [
																'id' => 'kecamatanDomisiliTertanggung',
																'placeholder' => 'Pilih Kecamatan ...',
																'allowClear' => true,
															],
														]);
															
															?>
															
															
														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT_KECAMATAN_T_INSTITUSI"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														<?php
															echo Select2::widget([
															'name' => 'kecamatanInstitusiTertanggung',
															'options' => [
																'id' => 'kecamatanInstitusiTertanggung',
																'placeholder' => 'Pilih Kecamatan ...',
																'allowClear' => true,
															],
														]);
															
															?>
															
															
														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT_KELURAHAN"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														<?php
															echo Select2::widget([
															'name' => 'kelurahan',
															'options' => [
																'id' => 'kelurahan',
																'placeholder' => 'Pilih Kelurahan ...',
																'allowClear' => true,
															],
														]);
															
															?>
															
															
														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT_KELURAHAN_DOMISILI"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														<?php
															echo Select2::widget([
															'name' => 'kelurahanDomisili',
															'options' => [
																'id' => 'kelurahanDomisili',
																'placeholder' => 'Pilih Kelurahan ...',
																'allowClear' => true,
															],
														]);
															
															?>
															
															
														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT_KELURAHAN_INSTITUSI"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														<?php
															echo Select2::widget([
															'name' => 'kelurahanInstitusi',
															'options' => [
																'id' => 'kelurahanInstitusi',
																'placeholder' => 'Pilih Kelurahan ...',
																'allowClear' => true,
															],
														]);
															
															?>
															
															
														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT_KELURAHAN_T"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														<?php
															echo Select2::widget([
															'name' => 'KelurahanTertanggung',
															'options' => [
																'id' => 'kelurahanTertanggung',
																'placeholder' => 'Pilih Kelurahan ...',
																'allowClear' => true,
															],
														]);
															
															?>
															
															
														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT_KELURAHAN_T_DOMISILI"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														<?php
															echo Select2::widget([
															'name' => 'kelurahanDomisiliTertanggung',
															'options' => [
																'id' => 'kelurahanDomisiliTertanggung',
																'placeholder' => 'Pilih Kelurahan ...',
																'allowClear' => true,
															],
														]);
															
															?>
															
															
														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT_KELURAHAN_T_INSTITUSI"){ ?>
												<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-md-8" style="float:left;margin-top:5px;">
														<?php
															echo Select2::widget([
															'name' => 'kelurahanInstitusiTertanggung',
															'options' => [
																'id' => 'kelurahanInstitusiTertanggung',
																'placeholder' => 'Pilih Kelurahan ...',
																'allowClear' => true,
															],
														]);
															
															?>
															
															
														</div>
													</div>
												<?php }else if($question->question_type == "LINEBREAK"){ ?>
												<div class="form-group" style="margin-top:30px;">
														<div class="col-md-12" style="float:left;font-size:14px;color:maroon;font-weight:bold;"><?=strtoupper($question->question_text); ?></div>
													</div>
												<?php }?>
											</div>
											
										<?php }else if($item->custom=='1'){?>
											<!--CUSTOM LAYOUT-->
											<?php if($question->question_type != 'RADIOB'  && $question->question_type != "PARAGRAPH" && $question->question_type != "RADIOW"){?>
												<div class="col-md-12" style="border-top:solid 1px #F6F6F6;padding-top:5px;padding-bottom:5px;border-width:90%;">

													<?php if($question->question_type == "RADIO"){ ?>
													
													<div class="row skin skin-square">
														<div style="width: 100%" class="form-group">
															<div class="col-md-6" style="float:left;margin-top:5px;padding-left:30px;">
																<label for="<?=$question->input_name ?>" style="font-weight:normal;font-size:14px;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
															</div>
															<div class="col-md-6" style="float:left;margin-top:5px;">
																<?php 
																$questionOption = QuestionsOption::find()->where(['question_id'=>$question->id])->all();
																foreach ($questionOption as $key3 => $option):
																	?>
																	<div style="float:left;position:relative;<?=$question->n_width=='70' ? 'width:70%' : 'width:30%;' ;?>">
																		<input class="<?=$option->other_answer==1? 'bukaindong':'tutupindong'; ?> <?=$question->is_required==1? 'required':'' ?>" type="radio" style="border-radius:0;" data-buka="<?php echo $option->other_answer_name;?>"  value="<?=$option->point_value ?>" name="<?=$question->input_name ?>" id="input-<?=$question->input_name ?>-<?=$key3 ?>">
																		<label for="input-<?=$question->input_name ?>-<?=$key3 ?>" style="font-size:12px;font-family:verdana;" class="<?=$option->other_answer==1? 'bukaindong':'tutupindong' ?>"  data-buka="<?php echo $option->other_answer_name;?>" ><?=$option->option_text ?></label>
																	</div>
																<?php endforeach; ?>
																  
															</div>

														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT"){ ?>
													<div class="form-group">
														<div class="col-md-6" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-size:13px;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-sm-6" style="float:left;margin-top:5px;">
															<input type="text" class="form-control <?=$question->is_required==1? 'required':'' ?>" style="max-width:120px;" name="<?=$question->input_name ?>" id="<?=$question->input_name ?>" autocomplete="OFF">
														</div>

													</div>
												<?php }else if($question->question_type == "CHECKBOX"){ ?>
													<div class="row skin skin-square">
														<div style="width: 100%" class="form-group">
															<div class="col-md-6" style="float:left;margin-top:5px;padding-left:30px;">
																<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
															</div>
															<div class="col-md-6" style="float:left;margin-top:5px;">
																<?php 
																$questionOption = QuestionsOption::find()->where(['question_id'=>$question->id])->all();
																foreach ($questionOption as $key3 => $option):
																	?>
																	<div style="float:left;position:relative;width:70%">
																		<input class="<?=$question->is_required==1? 'required':'' ?>" data-buka="<?php echo $option->other_answer_name;?>"   type="checkbox" value="<?=$option->point_value ?>" name="<?=$question->input_name ?>[]" id="input-<?=$question->input_name ?>-<?=$key3 ?>">
																		<label for="input-<?=$question->input_name ?>-<?=$key3 ?>"  data-buka="<?php echo $option->other_answer_name;?>"><?=$option->option_text ?></label>
																	</div>
																	
																	
																<?php endforeach; ?>
															</div>
														</div>
													</div>
												<?php }else if($question->question_type=="REMARK"){ ?>
												<div class="row skin skin-square">
														<div style="width: 100%" class="form-group">
															<div class="col-md-12" style="float:left;margin-top:5px;padding-left:30px;">
																<b><?=$question->question_text ?></b>
															</div>
															
														</div>
													</div>
												<?php } ?>

											</div>
											<?php } ?>


										<?php }if($item->custom=='3'){?>
											<!--CUSTOM LAYOUT-->
											

											<div class="col-md-12" style="border-top:solid 1px #F6F6F6;padding-top:5px;padding-bottom:5px;border-width:90%;">
											
											<?php if($question->question_type == "TABLE"){ ?>
											<div class="divTable">
												<b>MIFG My Managed Care</b>
												<div class="divTable">
													<div class="divTableBody">
													<div class="divTableRow">
													<div class="divTableCell" style="background-color:#001933;color:white;">&nbsp;PLAN</div>
													<div class="divTableCell" style="border-right:0px;background-color:#001933;color:white;">&nbsp;</div>
													<div class="divTableCell" style="border-right:0px;border-left:0px;background-color:#001933;color:white;">&nbsp;KELAS</div>
													</div>
													<div class="divTableRow">
													<div class="divTableCell" style="font-weight:bold;">&nbsp;&nbsp;Platinum
												
													</div>
													<div class="divTableCell">&nbsp;&nbsp;
															<div style="float:left;position:relative;width:50%">
																<label class="containerss"  for="kelas-p-0" style="font-size:12px;font-family:verdana;"  data-buka="p0">VIP
																	<input type="radio" data-buka="p0" value="P0" name="kelas" id="kelas-p-0">
																  <span class="checkmark"></span>
																</label>
															</div>
															
													</div>
													<div class="divTableCell">&nbsp;&nbsp;
															<div style="float:left;position:relative;width:50%">
																<label class="containerss"  for="kelas-p-1" style="font-size:12px;font-family:verdana;"  data-buka="p1">I
																	<input type="radio" data-buka="p1" value="P1" name="kelas" id="kelas-p-1">
																  <span class="checkmark"></span>
																</label>
															</div>
															
													</div>
													</div>
													
													</div>
												</div>
											</div>
												<!-- DivTable.com -->
												
												

											<?php }else if($question->question_type == "RADIO"){ ?> 
													<div class="row skin skin-square">
														<div style="width: 100%" class="form-group">
															<div class="col-md-4" style="float:left;margin-top:5px;padding-left:30px;">
																<label for="<?=$question->input_name ?>" style="font-weight:bold;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
															</div>
															

															<div class="col-md-8" style="float:left;margin-top:5px;">
																<?php 
																$questionOption = QuestionsOption::find()->where(['question_id'=>$question->id])->all();
																foreach ($questionOption as $key3 => $option):
																	?>
																	<div style="float:left;position:relative;<?=$question->n_width=='70' ? 'width:70%' : 'width:30%;' ;?>">
																		<input class="<?=$option->other_answer==1? 'bukaindong':'tutupindong'; ?> <?=$question->is_required==1? 'required':'' ?>" type="radio" style="border-radius:0;" data-buka="<?php echo $option->other_answer_name;?>"  value="<?=$option->point_value ?>" name="<?=$question->input_name ?>" id="input-<?=$question->input_name ?>-<?=$key3 ?>">
																		<label for="input-<?=$question->input_name ?>-<?=$key3 ?>" style="font-size:12px;font-family:verdana;" class="<?=$option->other_answer==1? 'bukaindong':'tutupindong' ?>"  data-buka="<?php echo $option->other_answer_name;?>" ><?=$option->option_text ?></label>
																	</div>
																	<?php 
																	if($option->other_answer=='1'){
																	?>
																	<div style="float:left;position:relative;width:40%;"  >
																		<input type="text" class="form-control"  name="<?php echo $option->other_answer_name;?>" id="<?php echo $option->other_answer_name;?>" autocomplete="OFF" style="display:none;">
																		
																	</div>
																	<?php } ?>
																<?php endforeach; ?>
																
															</div>

														</div>
													</div>
												<?php }else if($question->question_type == "TEXTINPUT_PROVIDER"){ ?>
													<div class="form-group">
														<div class="col-md-4" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-size:14px;"><b><?=$question->question_text ?></b></label>
														</div>
														<div class="col-sm-8" style="float:left;margin-top:5px;">
															<input type="text" class="form-control" name="<?=$question->input_name ?>" id="<?=$question->input_name ?>" value="Siloam Hospitals Group" placeholder="Siloam Hospitals Group" autocomplete="OFF" style="width:60%;" readonly>
														</div>

													</div>
												<?php }else if($question->question_type == "TEXTINPUT"){ ?>
													<div class="form-group" style="display:none;">
														<div class="col-md-6" style="float:left;margin-top:5px;">
															<label for="<?=$question->input_name ?>" style="font-size:13px;"><?=$question->question_text ?> : <?=$question->is_required==1? '<span class="danger">*</span></label>':'' ?></label>
														</div>
														<div class="col-sm-<?=$question->n_width;?>" style="float:left;margin-top:5px;">
															<input type="text" class="form-control <?=$question->is_required==1? 'required':'' ?>" name="<?=$question->input_name ?>" id="<?=$question->input_name ?>" autocomplete="OFF">
														</div>

													</div>
												<?php } ?>
												
												
												
												
												
											</div>


										<?php }else if($item->custom=='2'){ ?>

											<!--REMOVED-->
											
											<?php } ?>
											<?php 
										endforeach;  ?>
										
										<div class="col-lg-12 form-rom" style="">
											<?php echo $item->text_2 ?>
										</div>
									
										
										
										
										<?php if($item->id=='5'){ ?>
										
											<div class="col-lg-12" style="float:left;margin-top:5px;">
												<div class="col-md-4" style="float:left;margin-top:5px;color:#2E405C;font-weight:bold;">
													Manfaat Tambahan
												</div>
												<div class="col-md-8" style="float:left;margin-top:5px;">
												
												
														
													
														<div style="float:left;position:relative;width:70%">
															<label class="containerssc"  for="input-manfaatTambahan-0">Santunan Kematian
																	<input type="checkbox" class="bukamanfaat"  value="1" name="manfaatTambahan0" id="input-manfaatTambahan-0">
																	<span class="checkmarkc"></span>
															</label>
														</div>
														<div style="float:left;position:relative;width:70%">
															<label class="containerssc"  for="input-manfaatTambahan-1">Santunan Harian Rawat Inap
																	<input type="checkbox" class="bukamanfaat"  value="1" name="manfaatTambahan1" id="input-manfaatTambahan-1">
																	<span class="checkmarkc"></span>
															</label>
														</div>
														
														
													
												</div>

											</div>
														
											<br/>		
											<br/>
											<div class="col-md-12" style="border-top:solid 1px #F6F6F6;padding-top:5px;padding-bottom:5px;border-width:95%;display:none;" id="besaran_mft">
												<b>Manfaat Pilihan yang akan diperoleh : </b>
												<div class="col-md-12"><span id="mf01"></span></div>
												<div class="col-md-12"><span id="mf02"></span></div>
											</div>
											
											<br/>		
											<br/>		
											<div class="col-md-12" style="border-top:solid 1px #F6F6F6;padding-top:5px;padding-bottom:5px;border-width:95%;display:none;" id="penerima_mft">
											<br/>		
											<b>Hanya diisi jika mengambil manfaat tambahan Santunan Kematian</b> 
											<br/><b>Ahli Waris/Penerima Manfaat</b>
											<br/>
											
											
											
													
														<?php 
														for($a=0; $a<=2; $a++){
															$no = $a+1;
														?>
														<table style="border-collapse: collapse; width: 100%;font-family:Tahoma; font-size:12px; cellpadding:2;" cellpadding="2" cellspacing="1" border="1">
															<tbody class="item-list">
															<tr height="30">
																<td colspan="2"  style="background-color:#001933;color:white;">AHLI WARIS #<?=$no;?></td>
															</tr>
															
															<tr>
																<td style="width: 30%;">Nama Lengkap</td>
																<td style="width: 70%;"><input type="text" class="form-control" name="namaLengkappm[]" id="namaLengkappm[]" autocomplete="OFF" maxlength="35"></td>
															</tr>
															
															<tr>	
																<td style="width: 30%;">Nomor Induk Kependudukan</td>
																<td style="width: 70%;">
																	<input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  class="form-control" name="nomorIndukKependudukanpm[]" id="nomorIndukKependudukanpm[]" autocomplete="OFF"  maxlength="16">
																</td>
															</tr>
															
															<tr>
																<td style="width: 30%;">Tanggal Lahir</td>
																<td style="width: 70%;">
																	<input type="date" class="form-control" name="tanggalLahirpm[]" id="tanggalLahirpm[]" style="max-width:170px;font-size:14px;">
																</td>
																
															</tr>
															
															<tr>
																<td style="width: 30%;">Jenis Kelamin</td>
																<td style="width: 70%;">
																		<select class="custom-select form-control" id="jenisKelaminpm[]" name="jenisKelaminpm[]">
																			<option value=""></option>
																			<?php 
																			$jk = array("1" => "Laki-Laki", "0" => "Perempuan");
																			foreach ($jk as $opt => $val):
																				?>
																				<option value="<?=$opt?>"><?=$val?></option>
																			<?php endforeach; ?>
																		</select>
																</td>
															</tr>
															
															<tr>
																<td style="width: 30%;">Hubungan dengan Tertanggung</td>
																<td style="width: 70%;">
																	<select name="hubunganpm[]" id="hubunganpm[]" class="form-control">
																		<option value="Orang Tua">Orang Tua</option>
																		<option value="Suami/Isteri">Suami/Isteri</option>
																		<option value="Anak">Anak</option>
																		<option value="Saudara Kandung">Saudara Kandung</option>
																	</select>
																</td>
															</tr>
																
															<tr>
																<td style="width: 30%;">Persentase (%)</td>
																<td style="width: 70%;"><input type="number" class="form-control persentase" name="persentasepm[]" id="persentasepm[]" autocomplete="OFF"></td>
															</tr>		
																	
															</tbody>
														</table>
											<br/>
														<?php } ?>

													
											<br/>
											<!--
												<table style="border-collapse: collapse; width: 100%;font-family:Tahoma; font-size:12px; cellpadding:2;" border="1">
														<tr>
															<td style="width: 3.11286%;">No</td>
															<td style="width: 17.4976%;">Nama Lengkap</td>
															<td style="width: 18.6241%;">Nomor Induk Kependudukan</td>
															<td style="width: 13.0782%;">Tanggal Lahir</td>
															<td style="width: 13.0782%;">Jenis Kelamin</td>
															<td style="width: 13.0782%;">Hubungan dengan Tertanggung</td>
															<td style="width: 13.0849%;">Persentase (%)</td>
														</tr>
														
														<tbody class="item-list">
														<?php 
														for($a=0; $a<=2; $a++){
															$no = $a+1;
															?>
															<tr>
																<td style="width: 3.11286%;"><?php echo $no;?></td>
																<td style="width: 17.4976%;"><input type="text" class="form-control" name="namaLengkappm[]" id="namaLengkappm[]" autocomplete="OFF" maxlength="35"></td>
																<td style="width: 18.6241%;">
																<input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  class="form-control" name="nomorIndukKependudukanpm[]" id="nomorIndukKependudukanpm[]" autocomplete="OFF"  maxlength="16"></td>
																<td style="width: 13.0782%;">
																	<input type="date" class="form-control" name="tanggalLahirpm[]" id="tanggalLahirpm[]" style="max-width:170px;font-size:14px;"></td>
																	<td style="width: 13.0782%;">
																		<select class="custom-select form-control" id="jenisKelaminpm[]" name="jenisKelaminpm[]">
																			<option value=""></option>
																			<?php 
																			$jk = array("1" => "Laki-Laki", "0" => "Perempuan");
																			foreach ($jk as $opt => $val):
																				?>
																				<option value="<?=$opt?>"><?=$val?></option>
																			<?php endforeach; ?>
																		</select>
																	</td>
																	<td style="width: 13.0782%;"><input type="text" class="form-control" name="hubunganpm[]" id="hubunganpm[]" autocomplete="OFF"></td>
																	<td style="width: 13.0849%;"><input type="number" class="form-control persentase" name="persentasepm[]" id="persentasepm[]" autocomplete="OFF"></td>
																</tr>
															<?php } ?>

														</tbody>
													</table>
													
													-->
													
												</div>
										<?php } ?>
										
										
										<!--deleted hubungan-->
										
										
										<?php if($item->id=='7'){ ?>
										<br/>
											
											<div class="col-lg-12 khususwanita" style="display:none;float:left;margin-top:5px;">
												<b>Khusus Wanita</b>
											</div>
											
												<div class="col-lg-12 khususwanita" style="display:none;float:left;margin-top:5px;">
													<div class="row skin skin-square">
														<div class="col-md-6" style="float:left;margin-top:5px;color:#2E405C;font-weight:bold;">
															Apakah Anda Saat ini dalam kondisi hamil?
														</div>
														<div class="col-md-6" style="float:left;margin-top:5px;">
															<?php 
															$question = Questions::find()->where(['id'=>'103'])->one();
															$questionOption = QuestionsOption::find()->where(['question_id'=>'103'])->all();
															foreach ($questionOption as $key3 => $option):
																?>
																<div style="float:left;position:relative;width:30%">
																	<input type="radio" style="height:20px;width:20px;" value="<?=$option->point_value ?>" name="<?=$question->input_name ?>" id="input-<?=$question->input_name ?>-<?=$key3 ?>">
																	<label for="input-<?=$question->input_name ?>-<?=$key3 ?>" style="font-size:12px;font-family:verdana;" ><?=$option->option_text ?></label>
																</div>
																
															<?php endforeach; ?>
															
														</div>
													</div>
											</div>
											
										<br/>
										<!--Khusus Pria Dewasa-->
										<div class="col-lg-12 khususpriadewasa" style="display:none;float:left;margin-top:5px;margin-bottom:80px;">
												<div class="row skin skin-square">
														<div style="width: 100%" class="form-group">
															<div class="col-md-6" style="float:left;margin-top:5px;padding-left:30px;">
																Prostat
															</div>
															

															<div class="col-md-6" style="float:left;margin-top:5px;">
																<?php 
																	$question = Questions::find()->where(['id'=>'126'])->one();
																	$questionOption = QuestionsOption::find()->where(['question_id'=>'126'])->all();
																	foreach ($questionOption as $key3 => $option):
																?>
																	<div style="float:left;position:relative;width:70%">
																		<input type="radio" style="border-radius:0;"  value="<?=$option->point_value ?>" name="<?=$question->input_name ?>" id="input-<?=$question->input_name ?>-<?=$key3 ?>">
																		<label for="input-<?=$question->input_name ?>-<?=$key3 ?>" style="font-size:12px;font-family:verdana;" ><?=$option->option_text ?></label>
																	</div>
																<?php endforeach; ?>
															</div>
														</div>
												</div>	
										</div>
										
											
													
										<br/>
										
										<div id="khususdewasa" style="display:none;">
											
											<div class="col-lg-12" style="float:left;margin-top:5px;">
												<b>Lifestyle</b>
											</div>
											
											<div class="col-lg-12" style="float:left;margin-top:5px;">
											
												<div style="width: 100%" class="form-group">
														<div class="row skin skin-square">
																<div class="col-md-6" style="float:left;margin-top:5px;padding-left:30px;">
																	Apakah Anda Merokok? berapa batang per hari? :
																</div>
																

																<div class="col-md-6" style="float:left;margin-top:5px;">
																	<?php 
																		$question = Questions::find()->where(['id'=>'96'])->one();
																		$questionOption = QuestionsOption::find()->where(['question_id'=>'96'])->all();
																		foreach ($questionOption as $key3 => $option):
																	?>
																		<div style="float:left;position:relative;width:70%">
																			<input type="radio" style="border-radius:0;"  value="<?=$option->point_value ?>" name="<?=$question->input_name ?>" id="input-<?=$question->input_name ?>-<?=$key3 ?>">
																			<label for="input-<?=$question->input_name ?>-<?=$key3 ?>" style="font-size:12px;font-family:verdana;" ><?=$option->option_text ?></label>
																		</div>
																	<?php endforeach; ?>
																</div>
															</div>
													</div>
													
													<div style="width: 100%" class="form-group">
														<div class="row skin skin-square">
																<div class="col-md-6" style="float:left;margin-top:5px;padding-left:30px;">
																	Apakah Anda rutin mengkonsumsi alkohol? Berapa konsumsi alkohol anda per minggu (dalam ml)? :
																</div>
																

																<div class="col-md-6" style="float:left;margin-top:5px;">
																	<?php 
																		$question = Questions::find()->where(['id'=>'97'])->one();
																		$questionOption = QuestionsOption::find()->where(['question_id'=>'97'])->all();
																		foreach ($questionOption as $key3 => $option):
																	?>
																		<div style="float:left;position:relative;width:70%">
																			<input type="radio" style="border-radius:0;"  value="<?=$option->point_value ?>" name="<?=$question->input_name ?>" id="input-<?=$question->input_name ?>-<?=$key3 ?>">
																			<label for="input-<?=$question->input_name ?>-<?=$key3 ?>" style="font-size:12px;font-family:verdana;" ><?=$option->option_text ?></label>
																		</div>
																	<?php endforeach; ?>
																</div>
															</div>
													</div>
													
												<div style="width: 100%" class="form-group">
													<div class="row skin skin-square">
																<div class="col-md-6" style="float:left;margin-top:5px;padding-left:30px;">
																	Apakah Anda pernah menggunakan obat-obatan terlarang? :
																</div>
																

																<div class="col-md-6" style="float:left;margin-top:5px;">
																	<?php 
																		$question = Questions::find()->where(['id'=>'98'])->one();
																		$questionOption = QuestionsOption::find()->where(['question_id'=>'98'])->all();
																		foreach ($questionOption as $key3 => $option):
																	?>
																		<div style="float:left;position:relative;width:70%">
																			<input type="radio" style="border-radius:0;"  value="<?=$option->point_value ?>" name="<?=$question->input_name ?>" id="input-<?=$question->input_name ?>-<?=$key3 ?>">
																			<label for="input-<?=$question->input_name ?>-<?=$key3 ?>" style="font-size:12px;font-family:verdana;" ><?=$option->option_text ?></label>
																		</div>
																	<?php endforeach; ?>
																</div>
															</div>
													</div>
												
											</div>
											
										</div>
										
										<br/>
										
										<div id="khususanak" style="display:none;">
											
											<b>Khusus Anak (5-12 Tahun)</b>
											<br/>
										<!--Khusus Anak (5-12 Tahun)-->
										
														<div class="col-lg-12" style="float:left;margin-top:5px;">
														
														
												
														<div class="col-lg-12" style="float:left;margin-top:5px;">
															<div class="row skin skin-square">
																	<div class="col-md-6" style="float:left;margin-top:5px;color:#2E405C;">
																		Apakah telah diimunisasi BCG?
																	</div>
																	<div class="col-md-6" style="float:left;margin-top:5px;">
																		<?php 
																		$question = Questions::find()->where(['id'=>'108'])->one();
																		$questionOption = QuestionsOption::find()->where(['question_id'=>'108'])->all();
																		foreach ($questionOption as $key3 => $option):
																			?>
																			<div style="float:left;position:relative;width:30%">
																				<input type="radio" style="height:20px;width:20px;" value="<?=$option->point_value ?>" name="<?=$question->input_name ?>" id="input-<?=$question->input_name ?>-<?=$key3 ?>">
																				<label for="input-<?=$question->input_name ?>-<?=$key3 ?>" style="font-size:12px;font-family:verdana;" class="<?=$option->other_answer==1? 'bukaindong':'tutupindong' ?>"  data-buka="<?php echo $option->other_answer_name;?>" ><?=$option->option_text ?></label>
																			</div>
																			
																		<?php endforeach; ?>
																		
																	</div>
																</div>
														</div>
														
														<div class="col-lg-12" style="float:left;margin-top:5px;">
															<div class="row skin skin-square">
																<div class="col-md-6" style="float:left;margin-top:5px;color:#2E405C;">
																	Apakah telah diimunisasi DTP?
																</div>
																<div class="col-md-6" style="float:left;margin-top:5px;">
																	<?php 
																	$question = Questions::find()->where(['id'=>'109'])->one();
																	$questionOption = QuestionsOption::find()->where(['question_id'=>'109'])->all();
																	foreach ($questionOption as $key3 => $option):
																		?>
																		<div style="float:left;position:relative;width:30%">
																			<input type="radio" style="height:20px;width:20px;" value="<?=$option->point_value ?>" name="<?=$question->input_name ?>" id="input-<?=$question->input_name ?>-<?=$key3 ?>">
																			<label for="input-<?=$question->input_name ?>-<?=$key3 ?>" style="font-size:12px;font-family:verdana;" class="<?=$option->other_answer==1? 'bukaindong':'tutupindong' ?>"  data-buka="<?php echo $option->other_answer_name;?>" ><?=$option->option_text ?></label>
																		</div>
																		
																	<?php endforeach; ?>
																	
																</div>
															</div>
														</div>
														
														<div class="col-lg-12" style="float:left;margin-top:5px;">
															<div class="row skin skin-square">
																<div class="col-md-6" style="float:left;margin-top:5px;color:#2E405C;">
																	Apakah telah diimunisasi Polio?
																</div>
																<div class="col-md-6" style="float:left;margin-top:5px;">
																	<?php 
																	$question = Questions::find()->where(['id'=>'110'])->one();
																	$questionOption = QuestionsOption::find()->where(['question_id'=>'110'])->all();
																	foreach ($questionOption as $key3 => $option):
																		?>
																		<div style="float:left;position:relative;width:30%">
																			<input type="radio" style="height:20px;width:20px;" value="<?=$option->point_value ?>" name="<?=$question->input_name ?>" id="input-<?=$question->input_name ?>-<?=$key3 ?>">
																			<label for="input-<?=$question->input_name ?>-<?=$key3 ?>" style="font-size:12px;font-family:verdana;" class="<?=$option->other_answer==1? 'bukaindong':'tutupindong' ?>"  data-buka="<?php echo $option->other_answer_name;?>" ><?=$option->option_text ?></label>
																		</div>
																		
																	<?php endforeach; ?>
																	
																</div>
															</div>
														</div>
														
														<div class="col-lg-12" style="float:left;margin-top:5px;">
															<div class="row skin skin-square">
																<div class="col-md-6" style="float:left;margin-top:5px;color:#2E405C;">
																	Apakah telah diimunisasi Campak?
																</div>
																<div class="col-md-6" style="float:left;margin-top:5px;">
																	<?php 
																	$question = Questions::find()->where(['id'=>'111'])->one();
																	$questionOption = QuestionsOption::find()->where(['question_id'=>'111'])->all();
																	foreach ($questionOption as $key3 => $option):
																		?>
																		<div style="float:left;position:relative;width:30%">
																			<input type="radio" style="height:20px;width:20px;" value="<?=$option->point_value ?>" name="<?=$question->input_name ?>" id="input-<?=$question->input_name ?>-<?=$key3 ?>">
																			<label for="input-<?=$question->input_name ?>-<?=$key3 ?>" style="font-size:12px;font-family:verdana;" class="<?=$option->other_answer==1? 'bukaindong':'tutupindong' ?>"  data-buka="<?php echo $option->other_answer_name;?>" ><?=$option->option_text ?></label>
																		</div>
																		
																	<?php endforeach; ?>
																	
																</div>
															</div>
														</div>
														
														<div class="col-lg-12" style="float:left;margin-top:5px;">
															<div class="row skin skin-square">
																<div class="col-md-6" style="float:left;margin-top:5px;color:#2E405C;">
																	Apakah telah diimunisasi Hepatitis?
																</div>
																<div class="col-md-6" style="float:left;margin-top:5px;">
																	<?php 
																	$question = Questions::find()->where(['id'=>'112'])->one();
																	$questionOption = QuestionsOption::find()->where(['question_id'=>'112'])->all();
																	foreach ($questionOption as $key3 => $option):
																		?>
																		<div style="float:left;position:relative;width:30%">
																			<input type="radio" style="height:20px;width:20px;" value="<?=$option->point_value ?>" name="<?=$question->input_name ?>" id="input-<?=$question->input_name ?>-<?=$key3 ?>">
																			<label for="input-<?=$question->input_name ?>-<?=$key3 ?>" style="font-size:12px;font-family:verdana;" class="<?=$option->other_answer==1? 'bukaindong':'tutupindong' ?>"  data-buka="<?php echo $option->other_answer_name;?>" ><?=$option->option_text ?></label>
																		</div>
																		
																	<?php endforeach; ?>
																	
																</div>
															</div>
														</div>
														
														<div class="col-lg-12" style="float:left;margin-top:5px;">
															<div class="row skin skin-square">
																<div class="col-md-6" style="float:left;margin-top:5px;color:#2E405C;">
																	Apakah telah diimunisasi HiB?
																</div>
																<div class="col-md-6" style="float:left;margin-top:5px;">
																	<?php 
																	$question = Questions::find()->where(['id'=>'113'])->one();
																	$questionOption = QuestionsOption::find()->where(['question_id'=>'113'])->all();
																	foreach ($questionOption as $key3 => $option):
																		?>
																		<div style="float:left;position:relative;width:30%">
																			<input type="radio" style="height:20px;width:20px;" value="<?=$option->point_value ?>" name="<?=$question->input_name ?>" id="input-<?=$question->input_name ?>-<?=$key3 ?>">
																			<label for="input-<?=$question->input_name ?>-<?=$key3 ?>" style="font-size:12px;font-family:verdana;" class="<?=$option->other_answer==1? 'bukaindong':'tutupindong' ?>"  data-buka="<?php echo $option->other_answer_name;?>" ><?=$option->option_text ?></label>
																		</div>
																		
																	<?php endforeach; ?>
																	
																</div>
															</div>
														</div>
														
													<!--Khusus Anak (5-12 Tahun)-->
													</div>
										

										<br/>
										
										<?php } ?>
										
										<?php if($item->id=='2'){?>
										<div id="bwan" style="font-size:10px;color:#cdcdcd;border:solid #cdcdcd 0px;width:100%;height:60px;" onClick="bwan()">&nbsp;</div>
											
										<?php } ?>
										
										<?php if($item->id=='8'){ ?>
										
											<div class="col-lg-12" style="border-top:solid 1px #F6F6F6;padding-top:5px;padding-bottom:5px;border-width:100%;margin-top:20px;">
												<div style="width: 100%" class="form-group">
															<div class="col-md-4" style="float:left;margin-top:5px;padding-left:15px;">
																<label for="pencetakanPolis" style="font-weight:bold;">Pencetakan Polis : </label>
															</div>
															<div class="col-md-8" style="float:left;margin-top:5px;">
																
																	<div style="float:left;position:relative;width:50%">
																		<label class="containerss"  for="input-pencetakanPolis-0" style="font-size:12px;font-family:verdana;"  data-buka="">Ya
																			<input type="radio" value="1" name="pencetakanPolis" id="input-pencetakanPolis-0">
																		  <span class="checkmark"></span>
																		</label>
																	</div>
																	<div style="float:left;position:relative;width:50%">
																		<label class="containerss"  for="input-pencetakanPolis-1" style="font-size:12px;font-family:verdana;"  data-buka="">Tidak
																			<input type="radio" value="0" name="pencetakanPolis" id="input-pencetakanPolis-1">
																		  <span class="checkmark"></span>
																		</label>
																	</div>
																	
																	
																
															</div>

														</div>
												
												
											</div>
												
											<div class="col-lg-12" style="border-top:solid 1px #F6F6F6;padding-top:5px;padding-bottom:5px;border-width:100%;margin-top:20px;">
															<div class="col-md-4" style="float:left;margin-top:5px;padding-left:15px;">
																<label for="alamatPengirimanPolis" style="font-weight:bold;">Alamat Pengiriman Polis&nbsp;<br><i style="font-size:11px;">(Hanya diisi jika polis dicetak)</i> : </label>
															</div>
															<div class="col-md-8" style="float:left;margin-top:5px;">
																
																	<div style="float:left;position:relative;width:50%">
																		<label class="containerss"  for="input-alamatPengirimanPolis-0" style="font-size:12px;font-family:verdana;"  data-buka="">Sesuai Identitas
																			<input type="radio" value="0" name="alamatPengirimanPolis" id="input-alamatPengirimanPolis-0">
																		  <span class="checkmark"></span>
																		</label>
																	</div>
																	<div style="float:left;position:relative;width:50%">
																		<label class="containerss"  for="input-alamatPengirimanPolis-1" style="font-size:12px;font-family:verdana;"  data-buka="">Sesuai Domisili
																			<input type="radio" value="1" name="alamatPengirimanPolis" id="input-alamatPengirimanPolis-1">
																		  <span class="checkmark"></span>
																		</label>
																	</div>
																	
																	
																
															</div>
															
															
											</div>
											
											<div class="col-lg-12" style="display:none;border-top:solid 1px #F6F6F6;padding-top:5px;padding-bottom:5px;border-width:100%;margin-top:20px;">
													<div class="col-md-4" style="float:left;margin-top:5px;padding-left:15px;">
														<label for="alamatPengirimanPolis" style="font-weight:bold;">Ikhtisar polis dititipkan kepada : </label>
													</div>
													
													<div class="col-md-8" style="float:left;margin-top:5px;">
														
															<div style="float:left;position:relative;width:50%;">
																<label class="containerss"  for="input-ikhtisarPengirimanPolis-0" style="font-size:12px;font-family:verdana;"  data-buka="">Dititipkan kepada Penanggung
																	<input type="radio" value="0" name="ikhtisarPengirimanPolis" id="input-ikhtisarPengirimanPolis-0">
																  <span class="checkmark"></span>
																</label>
															</div>
															<div style="float:left;position:relative;width:50%">
																<label class="containerss"  for="input-ikhtisarPengirimanPolis-1" style="font-size:12px;font-family:verdana;"  data-buka="">Dikirim ke alamat Pemegang Polis
																	<input type="radio" value="1" name="ikhtisarPengirimanPolis" id="input-ikhtisarPengirimanPolis-1">
																  <span class="checkmark"></span>
																</label>
															</div>
															
													</div>
											</div>
														
													
											<div class="col-lg-12" style="border-top:solid 1px #F6F6F6;padding-top:5px;padding-bottom:5px;border-width:100%;margin-top:50px;margin-bottom:100px;">
													<div class="col-lg-12" style="float:left;margin-top:5px;">
													<input type="hidden" id="noAgen" name="noAgen" value="<?=$dataagent["NOAGEN"];?>">
													<input type="hidden" id="noLisensiAgen" name="noLisensiAgen" value="<?=$dataagent["NOLISENSIAGEN"];?>">
													<input type="hidden" id="namaAgen" name="namaAgen" value="<?=$dataagent["NAMAAGEN"];?>">
													<input type="hidden" id="teleponAgen" name="teleponAgen" value="<?=$dataagent["TELEPONAGEN"];?>">
													<input type="hidden" id="emailAgen" name="emailAgen" value="<?=$dataagent["EMAILAGEN"];?>">
													<input type="hidden" id="priadewasa" value="0">
														<label class="containerss" for="inputsetuju" >Saya setuju dan menerima segala risiko dari pernyataan di atas.
														  <input type="checkbox" value="1" name="inputsetuju" id="inputsetuju">
														  <span class="checkmark"></span>
														</label>
																		
													</div>
													<div class="col-lg-12" style="float:left;margin-top:5px;">
													<input type="hidden" id="clearkan" value="0">
														<?php echo Html::submitButton('SIMPAN DATA', ['class' => 'btn btn-success btnSubmit', 'disabled' => true, 'style' => 'width:180px;color:white;font-weight:bold;font-size:15px;height:40px;', 'id' => 'btnsubmit']) ?>
													</div>
											</div>
											
									<?php } ?>
									
									</div>
								</fieldset>
								
							
							
							<?php endforeach; ?>
							
						<?php ActiveForm::end(); ?>
				
			</div>
		</div>
		
	<div style="border:solid red 1px;background-color:white;position:absolute;bottom:0px;left:0px;height:200px;width:200px;z-index: 9999;border:solid yellow 0px;display:block;">
	&nbsp;
	</div>
	
	</div>
	

	
</div>

</div>
</section>
<!-- Form wizard with vertical tabs section end -->

</div>
<div class="bg-bottom" style="float:left;position:relative;">
	<img src="../images/backgrounds/batikbl.png" style=" position: absolute;bottom: 0px;left: 0px; height: 320px; z-index: 20;">
</div>

<div class="bg-bottom" style="float:left;position:relative;width:60%;font-family:'Myriad Pro Regular';font-size:13px;padding-left:10%;margin-top:50px;padding-bottom:50px;">
<font style="font-size:11px;">Produk ini merupakan Produk Asuransi dan bukan merupakan produk dan tanggung jawab Bank serta tidak termasuk dalam cakupan penjaminan Lembaga Penjamin Simpanan (LPS)</font>
<br/>
<br/>
<b>Terdapat syarat dan ketentuan yang berlaku.</b>
<br/>Informasi lebih lanjut hubungi Customer Service Mandiri Inhealth.
	<br/>
	<table width="60%" cellpadding="2" cellspacing="1">
	  <tr>
	   <td width="10%" valign="top"><img src="../images/backgrounds/ico-telp.png" style="height:15px"></td>
	   <td width="80%" valign="top">14701 (Plan Platinum)</td>
	  </tr>
	  <tr>
	   <td width="10%" valign="top"><img src="../images/backgrounds/ico-email.png" style="height:15px"></td>
	   <td width="80%" valign="top"><a href="mailto:customerservice@inhealth.co.id" style="color:black;">customerservice@inhealth.co.id</a></td>
	  </tr>
	  <tr>
	   <td width="10%" valign="top"><img src="../images/backgrounds/ico-cal.png" style="height:15px"></td>
	   <td width="80%" valign="top">www.mandiriinhealth.co.id</td>
	  </tr>
	  <tr>
	   <td width="10%" valign="top"><img src="../images/backgrounds/ico-loc.png" style="height:15px"></td>
	   <td width="80%" valign="top">Mengunjungi Kantor Layanan sesuai wilayah kerja<br/>PT Asuransi Jiwa Inhealth Indonesia</td>
	  </tr>
	</table>
</div>

<?php
$url_submit = \yii\helpers\Url::to(['send-form']);
$url_from_province = \yii\helpers\Url::to(['from-province']);
$base_url = Yii::$app->request->baseUrl;

$script = <<< JS


	



	$('#input-jenisKartuIdentitas-0').prop('checked',true);
	$('#input-jenisKartuIdentitasTertanggung-0').prop('checked',true);

	$('#input-pencetakanPolis-0').click(function(){
				swal({
				  title: "Cetak Polis",
				  text: "Permintaan pencetakan polis akan dikenakan biaya sebesar Rp. 150.000!",
				  icon: "success",
				  button: "Aww yiss!",
				});
			});
		

		$(".bukaindong").click( function() {
			// alert($(this).attr("data-buka"));
			var buka = $(this).attr("data-buka");
			$("#"+buka).show(500);
			document.getElementById(buka).focus();
		});
		
		$(".tutupindong").click( function() {
			var buka = $(this).attr("data-buka");
			$("#"+buka).val('');
			$("#"+buka).hide(500);
		});
		
		
		
		$('#provinsi').on('select2:select', function (e) {
			var data = e.params.data;
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : data.text, kota : '', kecamatan : '', kelurahan : ''},
				dataType:"json",
				success: function(data){
					$('#kota').find('option').remove().end();
	
					datakota = JSON.parse(data);
					for(var s=0;s<datakota.length;s++){
						var newOption = new Option(datakota[s].name, datakota[s].name, false, false);
						$('#kota').append(newOption).trigger('change');						
					}
											
					
					$('#kota').val('');
					$('#kecamatan').val('');
					$('#kelurahan').val('');
					$('#kecamatan').find('option').remove().end();
					$('#kelurahan').find('option').remove().end();
					
				}
			});
			
		});
		
		
		
		$('#kota').on('select2:select', function (e) {
			var data = e.params.data;
			var provinsi = $('#provinsi').val();
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : provinsi, kota : data.text, kecamatan : '', kelurahan : ''},
				dataType:"json",
				success: function(data){
					$('#kecamatan').find('option').remove().end();
					
					datakcm = JSON.parse(data);
					for(var s=0;s<datakcm.length;s++){
						var newOption = new Option(datakcm[s].name, datakcm[s].name, false, false);
						// $('#kecamatan').append(newOption).trigger('change');						
						$('#kecamatan').append(newOption);						
					}
					$('#kecamatan').val('');
					$('#kelurahan').find('option').remove().end();
				}
			});
			
		});
		
		
		$('#kecamatan').on('select2:select', function (e) {
			var data = e.params.data;
			var provinsi = $('#provinsi').val();
			var kota = $('#kota').val();
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : provinsi, kota : kota, kecamatan : data.text, kelurahan : ''},
				dataType:"json",
				success: function(data){
					$('#kelurahan').find('option').remove().end();
					
					datakel = JSON.parse(data);
					for(var s=0;s<datakel.length;s++){
						var newOption = new Option(datakel[s].name, datakel[s].name, false, false);
						// $('#kelurahan').append(newOption).trigger('change');						
						$('#kelurahan').append(newOption);						
					}
					
					$('#kelurahan').val('');
					
				}
			});
			
		});
		
		
		$('#kelurahan').on('select2:select', function (e) {
			var data = e.params.data;
			var provinsi = $('#provinsi').val();
			var kota = $('#kota').val();
			var kecamatan = $('#kecamatan').val();
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : provinsi, kota : kota, kecamatan : kecamatan, kelurahan : data.text},
				dataType:"json",
				success: function(data){
					datakel = JSON.parse(data);
					
					
					$('#kodepos').val(datakel[0].name);
					
				}
			});
			
		});
		
		
		
		
		$('#provinsiDomisili').on('select2:select', function (e) {
			var data = e.params.data;
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : data.text, kota : '', kecamatan : '', kelurahan : ''},
				dataType:"json",
				success: function(data){
					$('#kotaDomisili').find('option').remove().end();
	
					datakota = JSON.parse(data);
					for(var s=0;s<datakota.length;s++){
						var newOption = new Option(datakota[s].name, datakota[s].name, false, false);
						$('#kotaDomisili').append(newOption).trigger('change');						
					}
					
					$('#kotaDomisili').val('');
					$('#kecamatanDomisili').find('option').remove().end();
					$('#kelurahanDomisili').find('option').remove().end();
					
				}
			});
			
		});
		
		
		
		$('#kotaDomisili').on('select2:select', function (e) {
			var data = e.params.data;
			var provinsi = $('#provinsiDomisili').val();
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : provinsi, kota : data.text, kecamatan : '', kelurahan : ''},
				dataType:"json",
				success: function(data){
					$('#kecamatanDomisili').find('option').remove().end();
					
					datakcm = JSON.parse(data);
					for(var s=0;s<datakcm.length;s++){
						var newOption = new Option(datakcm[s].name, datakcm[s].name, false, false);
						// $('#kecamatanDomisili').append(newOption).trigger('change');						
						$('#kecamatanDomisili').append(newOption);						
					}
					
					$('#kecamatanDomisili').val('');
					$('#kelurahanDomisili').find('option').remove().end();
				}
			});
			
		});
		
		$('#kecamatanDomisili').on('select2:select', function (e) {
			var data = e.params.data;
			var provinsi = $('#provinsiDomisili').val();
			var kota = $('#kotaDomisili').val();
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : provinsi, kota : kota, kecamatan : data.text, kelurahan : ''},
				dataType:"json",
				success: function(data){
					$('#kelurahanDomisili').find('option').remove().end();
					
					datakel = JSON.parse(data);
					for(var s=0;s<datakel.length;s++){
						var newOption = new Option(datakel[s].name, datakel[s].name, false, false);
						// $('#kelurahanDomisili').append(newOption).trigger('change');						
						$('#kelurahanDomisili').append(newOption);
					}
					
					$('#kelurahanDomisili').val('');
					
				}
			});
			
		});
		
		
		
		$('#kelurahanDomisili').on('select2:select', function (e) {
			var data = e.params.data;
			var provinsi = $('#provinsiDomisili').val();
			var kota = $('#kotaDomisili').val();
			var kecamatan = $('#kecamatanDomisili').val();
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : provinsi, kota : kota, kecamatan : kecamatan, kelurahan : data.text},
				dataType:"json",
				success: function(data){
					datakel = JSON.parse(data);
					
					
					$('#kodeposDomisili').val(datakel[0].name);
					
				}
			});
			
		});
		
		
		
		
		$('#provinsiInstitusi').on('select2:select', function (e) {
			var data = e.params.data;
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : data.text, kota : '', kecamatan : '', kelurahan : ''},
				dataType:"json",
				success: function(data){
					$('#kotaInstitusi').find('option').remove().end();
	
					datakota = JSON.parse(data);
					for(var s=0;s<datakota.length;s++){
						var newOption = new Option(datakota[s].name, datakota[s].name, false, false);
						$('#kotaInstitusi').append(newOption).trigger('change');						
					}
					
					$('#kotaInstitusi').val('');
					$('#kecamatanInstitusi').find('option').remove().end();
					$('#kelurahanInstitusi').find('option').remove().end();
					
				}
			});
			
		});
		
		$('#kotaInstitusi').on('select2:select', function (e) {
			var data = e.params.data;
			var provinsi = $('#provinsiInstitusi').val();
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : provinsi, kota : data.text, kecamatan : '', kelurahan : ''},
				dataType:"json",
				success: function(data){
					$('#kecamatanInstitusi').find('option').remove().end();
					
					datakcm = JSON.parse(data);
					for(var s=0;s<datakcm.length;s++){
						var newOption = new Option(datakcm[s].name, datakcm[s].name, false, false);
						// $('#kecamatanInstitusi').append(newOption).trigger('change');						
						$('#kecamatanInstitusi').append(newOption);						
					}
					
					$('#kecamatanInstitusi').val('');
					$('#kelurahanInstitusi').find('option').remove().end();
				}
			});
			
		});
		
		$('#kecamatanInstitusi').on('select2:select', function (e) {
			var data = e.params.data;
			var provinsi = $('#provinsiInstitusi').val();
			var kota = $('#kotaInstitusi').val();
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : provinsi, kota : kota, kecamatan : data.text, kelurahan : ''},
				dataType:"json",
				success: function(data){
					$('#kelurahanInstitusi').find('option').remove().end();
					
					datakel = JSON.parse(data);
					for(var s=0;s<datakel.length;s++){
						var newOption = new Option(datakel[s].name, datakel[s].name, false, false);
						// $('#kelurahanInstitusi').append(newOption).trigger('change');						
						$('#kelurahanInstitusi').append(newOption);
					}
					
					$('#kelurahanInstitusi').val('');
					
				}
			});
			
		});
		
		
		$('#kelurahanInstitusi').on('select2:select', function (e) {
			var data = e.params.data;
			var provinsi = $('#provinsiInstitusi').val();
			var kota = $('#kotaInstitusi').val();
			var kecamatan = $('#kecamatanInstitusi').val();
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : provinsi, kota : kota, kecamatan : kecamatan, kelurahan : data.text},
				dataType:"json",
				success: function(data){
					datakel = JSON.parse(data);
					
					
					$('#kodePosInstitusi').val(datakel[0].name);
					
				}
			});
			
		});
		
		
		
		
		
		
		
		
		
		
		
		
		$('#provinsiTertanggung').on('select2:select', function (e) {
			var data = e.params.data;
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : data.text, kota : '', kecamatan : '', kelurahan : ''},
				dataType:"json",
				success: function(data){
					$('#kotaTertanggung').find('option').remove().end();
	
					datakota = JSON.parse(data);
					for(var s=0;s<datakota.length;s++){
						var newOption = new Option(datakota[s].name, datakota[s].name, false, false);
						$('#kotaTertanggung').append(newOption).trigger('change');						
					}
											
					
					$('#kotaTertanggung').val('');
					$('#KecamatanTertanggung').val('');
					$('#kelurahanTertanggung').val('');
					$('#kecamatanTertanggung').find('option').remove().end();
					$('#kelurahanTertanggung').find('option').remove().end();
					
				}
			});
			
		});
		
		
		
		$('#kotaTertanggung').on('select2:select', function (e) {
			var data = e.params.data;
			var provinsi = $('#provinsiTertanggung').val();
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : provinsi, kota : data.text, kecamatan : '', kelurahan : ''},
				dataType:"json",
				success: function(data){
					$('#kecamatanTertanggung').find('option').remove().end();
					
					datakcm = JSON.parse(data);
					for(var s=0;s<datakcm.length;s++){
						var newOption = new Option(datakcm[s].name, datakcm[s].name, false, false);
						// $('#kecamatan').append(newOption).trigger('change');						
						$('#kecamatanTertanggung').append(newOption);						
					}
					$('#kecamatanTertanggung').val('');
					$('#kelurahanTertanggung').find('option').remove().end();
				}
			});
			
		});
		
		
		$('#kecamatanTertanggung').on('select2:select', function (e) {
			var data = e.params.data;
			var provinsi = $('#provinsiTertanggung').val();
			var kota = $('#kotaTertanggung').val();
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : provinsi, kota : kota, kecamatan : data.text, kelurahan : ''},
				dataType:"json",
				success: function(data){
					$('#kelurahanTertanggung').find('option').remove().end();
					
					datakel = JSON.parse(data);
					for(var s=0;s<datakel.length;s++){
						var newOption = new Option(datakel[s].name, datakel[s].name, false, false);
						// $('#kelurahanTertanggung').append(newOption).trigger('change');						
						$('#kelurahanTertanggung').append(newOption);
					}
					
					$('#kelurahanTertanggung').val('');
					
				}
			});
			
		});
		
		$('#kelurahanTertanggung').on('select2:select', function (e) {
			var data = e.params.data;
			var provinsi = $('#provinsiTertanggung').val();
			var kota = $('#kotaTertanggung').val();
			var kecamatan = $('#kecamatanTertanggung').val();
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : provinsi, kota : kota, kecamatan : kecamatan, kelurahan : data.text},
				dataType:"json",
				success: function(data){
					
					datakel = JSON.parse(data);
					
					
					$('#KodePosTertanggung').val(datakel[0].name);
					
				}
			});
			
		});
		
		
		
		
		$('#provinsiDomisiliTertanggung').on('select2:select', function (e) {
			var data = e.params.data;
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : data.text, kota : '', kecamatan : '', kelurahan : ''},
				dataType:"json",
				success: function(data){
					$('#kotaDomisiliTertanggung').find('option').remove().end();
	
					datakota = JSON.parse(data);
					for(var s=0;s<datakota.length;s++){
						var newOption = new Option(datakota[s].name, datakota[s].name, false, false);
						$('#kotaDomisiliTertanggung').append(newOption).trigger('change');						
					}
					
					$('#kotaDomisiliTertanggung').val('');
					$('#kecamatanDomisiliTertanggung').find('option').remove().end();
					$('#kelurahanDomisiliTertanggung').find('option').remove().end();
					
				}
			});
			
		});
		
		
		
		$('#kotaDomisiliTertanggung').on('select2:select', function (e) {
			var data = e.params.data;
			var provinsi = $('#provinsiDomisiliTertanggung').val();
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : provinsi, kota : data.text, kecamatan : '', kelurahan : ''},
				dataType:"json",
				success: function(data){
					$('#kecamatanDomisiliTertanggung').find('option').remove().end();
					
					datakcm = JSON.parse(data);
					for(var s=0;s<datakcm.length;s++){
						var newOption = new Option(datakcm[s].name, datakcm[s].name, false, false);
						// $('#kecamatanDomisili').append(newOption).trigger('change');						
						$('#kecamatanDomisiliTertanggung').append(newOption);						
					}
					
					$('#kecamatanDomisiliTertanggung').val('');
					$('#kelurahanDomisiliTertanggung').find('option').remove().end();
				}
			});
			
		});
		
		$('#kecamatanDomisiliTertanggung').on('select2:select', function (e) {
			var data = e.params.data;
			var provinsi = $('#provinsiDomisiliTertanggung').val();
			var kota = $('#kotaDomisiliTertanggung').val();
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : provinsi, kota : kota, kecamatan : data.text, kelurahan : ''},
				dataType:"json",
				success: function(data){
					$('#kelurahanDomisiliTertanggung').find('option').remove().end();
					
					datakel = JSON.parse(data);
					for(var s=0;s<datakel.length;s++){
						var newOption = new Option(datakel[s].name, datakel[s].name, false, false);
						// $('#kelurahanDomisiliTertanggung').append(newOption).trigger('change');						
						$('#kelurahanDomisiliTertanggung').append(newOption);
					}
					
					$('#kelurahanDomisiliTertanggung').val('');
					
				}
			});
			
		});
		
		$('#kelurahanDomisiliTertanggung').on('select2:select', function (e) {
			var data = e.params.data;
			var provinsi = $('#provinsiDomisiliTertanggung').val();
			var kota = $('#kotaDomisiliTertanggung').val();
			var kecamatan = $('#kecamatanDomisiliTertanggung').val();
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : provinsi, kota : kota, kecamatan : kecamatan, kelurahan : data.text},
				dataType:"json",
				success: function(data){
					
					datakel = JSON.parse(data);
					
					
					$('#kodeposDomisiliTertanggung').val(datakel[0].name);
					
				}
			});
			
		});
		
		
		
		
		
		$('#provinsiInstitusiTertanggung').on('select2:select', function (e) {
			var data = e.params.data;
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : data.text, kota : '', kecamatan : '', kelurahan : ''},
				dataType:"json",
				success: function(data){
					$('#kotaInstitusiTertanggung').find('option').remove().end();
	
					datakota = JSON.parse(data);
					for(var s=0;s<datakota.length;s++){
						var newOption = new Option(datakota[s].name, datakota[s].name, false, false);
						$('#kotaInstitusiTertanggung').append(newOption).trigger('change');						
					}
					
					$('#kotaInstitusiTertanggung').val('');
					$('#kecamatanInstitusiTertanggung').find('option').remove().end();
					$('#kelurahanInstitusiTertanggung').find('option').remove().end();
					
				}
			});
			
		});
		
		$('#kotaInstitusiTertanggung').on('select2:select', function (e) {
			var data = e.params.data;
			var provinsi = $('#provinsiInstitusiTertanggung').val();
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : provinsi, kota : data.text, kecamatan : '', kelurahan : ''},
				dataType:"json",
				success: function(data){
					$('#kecamatanInstitusiTertanggung').find('option').remove().end();
					
					datakcm = JSON.parse(data);
					for(var s=0;s<datakcm.length;s++){
						var newOption = new Option(datakcm[s].name, datakcm[s].name, false, false);
						// $('#kecamatanInstitusi').append(newOption).trigger('change');						
						$('#kecamatanInstitusiTertanggung').append(newOption);						
					}
					
					$('#kecamatanInstitusiTertanggung').val('');
					$('#kelurahanInstitusiTertanggung').find('option').remove().end();
				}
			});
			
		});
		
		$('#kecamatanInstitusiTertanggung').on('select2:select', function (e) {
			var data = e.params.data;
			var provinsi = $('#provinsiInstitusiTertanggung').val();
			var kota = $('#kotaInstitusiTertanggung').val();
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : provinsi, kota : kota, kecamatan : data.text, kelurahan : ''},
				dataType:"json",
				success: function(data){
					$('#kelurahanInstitusiTertanggung').find('option').remove().end();
					
					datakel = JSON.parse(data);
					for(var s=0;s<datakel.length;s++){
						var newOption = new Option(datakel[s].name, datakel[s].name, false, false);
						// $('#kelurahanInstitusiTertanggung').append(newOption).trigger('change');						
						$('#kelurahanInstitusiTertanggung').append(newOption);
					}
					
					$('#kelurahanInstitusiTertanggung').val('');
					
				}
			});
			
		});
		
		$('#kelurahanInstitusiTertanggung').on('select2:select', function (e) {
			var data = e.params.data;
			var provinsi = $('#provinsiInstitusiTertanggung').val();
			var kota = $('#kotaInstitusiTertanggung').val();
			var kecamatan = $('#kecamatanInstitusiTertanggung').val();
			
			$.ajax({
				type: "POST",
				url: "$url_from_province", 
				data: {provinsi : provinsi, kota : kota, kecamatan : kecamatan, kelurahan : data.text},
				dataType:"json",
				success: function(data){
					
					datakel = JSON.parse(data);
					
					
					$('#kodePosInstitusiTertanggung').val(datakel[0].name);
					
				}
			});
			
		});
		
		
		
		
		
		$('.item-list').on('keyup', '.persentase', function(){
			var pers = 0;
			if($(this).parent().parent().parent().find('.persentase').val() != ''){
				pers = $(this).parent().parent().parent().find('.persentase').val();
				
			}
			hitungtotal();
		});
		
		
		function hitungtotal(){
			var pers = $('.item-list').find('.persentase');
			var tper = 0;
			pers.each(function(){
				if($(this).val()==''){
					tper += 0;
				}else{
					tper += parseInt($(this).val());
				}
			});
			
			
			
			if((parseInt(tper)) > 100){
				 pers.each(function(){
					 $(this).val('0');
				 });
				 swal({
						html:true,
						title: 'IFG Life',
						text: 'Total Persentase tidak boleh melebihi 100!',
						type: 'error',
						timer: 5000,
						showCancelButton: false,
						showConfirmButton: true
					});
			}
		}
		
		
		$(".btnSubmit").on('click',function(){
			 event.preventDefault();
			 
			 

			swal({
				title: "IFG Life",
				text: "Harap Menunggu... Data Sedang Diproses",
				type: false,
				showCancelButton: true,
				showConfirmButton: true,
				imageUrl: '$base_url'+'/images/loading.gif',
			});
			

			var data = $('form').serialize();
			

			$.ajax({
				type: "POST",
				url: "$url_submit", 
				data: {data : data},
				dataType:"json",
				success: function(resultData) {
					if(resultData.respcode == '1'){
						swal({
							html:true,
							title: 'IFG Life',
							text: 'Data berhasil disimpan',
							type: 'success',
							timer: 5000,
							showCancelButton: false,
							showConfirmButton: true,
							},function () {
								//untuk live, buka alamat https://registration.ifg-life.id/otp;
								 location.href = "/otp";
							}
						);
					}else{
						swal({
							html:true,
							title: 'REGISTRASI GAGAL!',
							text: resultData.resp_msg,
							type: 'error',
							timer: 12000,
							showCancelButton: false,
							showConfirmButton: true
						});
					}
				}
			});
		});
		
		

		$('#checkbox_domisili').click(function(){
				if($(this).prop("checked") == true){
					console.log("Checkbox is checked.");
				}
				else if($(this).prop("checked") == false){
					console.log("Checkbox is unchecked.");
				}
			});





		$('#kelas-p-0').click(function() {
			if($('#input-manfaatTambahan-0').is(':checked')){
				$('#besaran_mft').show(500);
				swal({
							  title: "Manfaat Asuransi Pilihan",
							  text: "Santunan Meninggal Dunia karena Sakit/alami atau kecelakaan yang akan diterima pada Kelas VIP adalah sebesar Rp. 50,000,000",
							  icon: "success",
							  button: "Aww yiss!",
							});
				$('#mf01').html("&#10003; Santunan Meninggal Dunia karena Sakit/alami atau kecelakaan yang akan diterima pada Kelas VIP adalah sebesar Rp. 50,000,000");
			}else{
				$('#mf01').html("");
			}
			
			if($('#input-manfaatTambahan-1').is(':checked')){
				$('#besaran_mft').show(500);
				swal({
							  title: "Manfaat Asuransi Pilihan",
							  text: "Santunan Harian Rawat Inap di Rumah Sakit pada kelas ini adalah sebesar Rp. 250,000/Hari",
							  icon: "success",
							  button: "Aww yiss!",
							});
				$('#mf02').html("&#10003; Santunan Harian Rawat Inap di Rumah Sakit pada kelas ini adalah sebesar Rp. 250,000/Hari");
			}else{
				$('#mf02').html("");
			}
		});

		$('#kelas-p-1').click(function() {
				if($('#input-manfaatTambahan-0').is(':checked')){
					$('#besaran_mft').show(500);
					swal({
							  title: "Manfaat Asuransi Pilihan",
							  text: "Santunan Meninggal Dunia karena Sakit/alami atau kecelakaan yang akan diterima pada Kelas VIP adalah sebesar Rp. 25,000,000",
							  icon: "success",
							  button: "Aww yiss!",
							});
					$('#mf01').html("&#10003; Santunan Meninggal Dunia karena Sakit/alami atau kecelakaan yang akan diterima pada Kelas VIP adalah sebesar Rp. 25,000,000");
				}else{
					$('#mf01').html("");
				}
				if($('#input-manfaatTambahan-1').is(':checked')){
					$('#besaran_mft').show(500);
					swal({
							  title: "Manfaat Asuransi Pilihan",
							  text: "Santunan Harian Rawat Inap di Rumah Sakit pada kelas ini adalah sebesar Rp. 150,000/Hari",
							  icon: "success",
							  button: "Aww yiss!",
							});
					$('#mf02').html("&#10003; Santunan Harian Rawat Inap di Rumah Sakit pada kelas ini adalah sebesar Rp. 150,000/Hari");
				}else{
					$('#mf02').html("");
				}
				
		});
		
		
			
		

		$('#input-manfaatTambahan-0').click(function() {
			var boxes = $('input[name=kelas]:checked');
			if(boxes.length > 0){
				if($('#input-manfaatTambahan-0').is(':checked')){
					$('#besaran_mft').show(500);
					if($('#kelas-p-0').is(':checked')){
						swal({
							  title: "Manfaat Asuransi Pilihan",
							  text: "Santunan Meninggal Dunia karena Sakit/alami atau kecelakaan yang akan diterima pada Kelas VIP adalah sebesar Rp. 50,000,000",
							  icon: "success",
							  button: "Aww yiss!",
							});
							$('#mf01').html("&#10003; Santunan Meninggal Dunia karena Sakit/alami atau kecelakaan yang akan diterima pada Kelas VIP adalah sebesar Rp. 50,000,000");
					}else if($('#kelas-p-1').is(':checked')){
						$('#besaran_mft').show(500);
						swal({
							  title: "Manfaat Asuransi Pilihan",
							  text: "Santunan Meninggal Dunia karena Sakit/alami atau kecelakaan yang akan diterima pada Kelas ini adalah sebesar Rp. 25,000,000",
							  icon: "success",
							  button: "Aww yiss!",
							});
						$('#mf01').html("&#10003; Santunan Meninggal Dunia karena Sakit/alami atau kecelakaan yang akan diterima pada Kelas VIP adalah sebesar Rp. 25,000,000");
					}
					$('#penerima_mft').show(500);
				}else{
					$('#mf01').html("");
					$('#penerima_mft').hide(500);
				}
			}else{
				$('#input-manfaatTambahan-0').prop('checked', false);
				
				swal({
				  title: "Manfaat Tambahan",
				  text: "Pilih Kelas Terlebih Dahulu!",
				  icon: "warning",
				  button: "Aww yiss!",
				});
				
				return false;
			}
		});
		
		$('#input-manfaatTambahan-1').click(function() {
			var boxes = $('input[name=kelas]:checked');
			if(boxes.length > 0){
				if($('#input-manfaatTambahan-1').is(':checked')){
					$('#besaran_mft').show(500);
					if($('#kelas-p-0').is(':checked')){
						swal({
							  title: "Manfaat Asuransi Pilihan",
							  text: "Santunan Harian Rawat Inap di Rumah Sakit pada kelas ini adalah sebesar Rp. 250,000/Hari",
							  icon: "success",
							  button: "Aww yiss!",
							});
						$('#mf02').html("&#10003; Santunan Harian Rawat Inap di Rumah Sakit pada kelas ini adalah sebesar Rp. 250,000/Hari");
					}else if($('#kelas-p-1').is(':checked')){
						$('#besaran_mft').show(500);
						swal({
							  title: "Manfaat Asuransi Pilihan",
							  text: "Santunan Harian Rawat Inap di Rumah Sakit pada kelas ini adalah sebesar Rp. 150,000/Hari",
							  icon: "success",
							  button: "Aww yiss!",
							});
						$('#mf02').html("&#10003; Santunan Harian Rawat Inap di Rumah Sakit pada kelas ini adalah sebesar Rp. 150,000/Hari");
					}
					
				}else{
					$('#mf02').html("");
				}
			}else{
				$('#input-manfaatTambahan-1').prop('checked', false);
				
				swal({
				  title: "Manfaat Tambahan",
				  text: "Pilih Kelas Terlebih Dahulu!",
				  icon: "warning",
				  button: "Aww yiss!",
				});
				return false;
			}
		});
		
		$('#input-manfaatTambahan-2').click(function() {
			if($('#input-manfaatTambahan-0').is(':checked')){
				$('#penerima_mft').show(500);
			}else{
				$('#penerima_mft').hide(500);
			}
		});
		
		
		
		
		$('.row').click(function() {
			
			 $('#inputsetuju').click(function(){
				if($(this).prop("checked") == true){
					$("#btnsubmit").prop('disabled',false);
				}
				else if($(this).prop("checked") == false){
				   $("#btnsubmit").prop('disabled',true);
				}
			});
			
			if($('#input-pekerjaan-5').is(':checked')){
				$('#bidangUsaha').val('-');
				$('#jabatan').val('-');
				$('#teleponInstitusi').val('-');
				$('#namaInstitusiTempatKerja').val('-');
				$('#alamatinstitusi').val($('#alamatDomisili').val());
				var newOptionp = $("<option selected='selected'></option>").val($('#provinsiDomisili').val()).text($('#provinsiDomisili').val())
				$("#provinsiInstitusi").append(newOptionp).trigger('change');
				var newOptionp = $("<option selected='selected'></option>").val($('#kotaDomisili').val()).text($('#kotaDomisili').val())
				$("#kotaInstitusi").append(newOptionp).trigger('change');
				var newOptionp = $("<option selected='selected'></option>").val($('#kecamatanDomisili').val()).text($('#kecamatanDomisili').val())
				$("#kecamatanInstitusi").append(newOptionp).trigger('change');
				var newOptionp = $("<option selected='selected'></option>").val($('#kelurahanDomisili').val()).text($('#kelurahanDomisili').val())
				$("#kelurahanInstitusi").append(newOptionp).trigger('change');
				$("#RWInstitusi").val($('#RWDomisili').val());
				$("#RTInstitusi").val($('#RTDomisili').val());
				$("#kodePosInstitusi").val($('#kodeposDomisili').val());
			}
			
			if($('#input-pekerjaanTertanggung-5').is(':checked')){
				$('#bidangUsahaTertanggung').val('-');
				$('#jabatanTertanggung').val('-');
				$('#teleponInstitusiTertanggung').val('-');
				$('#namaInstitusiTempatKerjaTertanggung').val('-');
				$('#alamatinstitusiTertanggung').val($('#alamatDomisiliTertanggung').val());
				var newOptionp = $("<option selected='selected'></option>").val($('#provinsiDomisiliTertanggung').val()).text($('#provinsiDomisiliTertanggung').val())
				$("#provinsiInstitusiTertanggung").append(newOptionp).trigger('change');
				var newOptionp = $("<option selected='selected'></option>").val($('#kotaDomisiliTertanggung').val()).text($('#kotaDomisiliTertanggung').val())
				$("#kotaInstitusiTertanggung").append(newOptionp).trigger('change');
				var newOptionp = $("<option selected='selected'></option>").val($('#kecamatanDomisiliTertanggung').val()).text($('#kecamatanDomisiliTertanggung').val())
				$("#kecamatanInstitusiTertanggung").append(newOptionp).trigger('change');
				var newOptionp = $("<option selected='selected'></option>").val($('#kelurahanDomisiliTertanggung').val()).text($('#kelurahanDomisiliTertanggung').val())
				$("#kelurahanInstitusiTertanggung").append(newOptionp).trigger('change');
				$("#RWInstitusiTertanggung").val($('#RWDomisiliTertanggung').val());
				$("#RTInstitusiTertanggung").val($('#RTDomisiliTertanggung').val());
				$("#kodePosInstitusiTertanggung").val($('#kodeposDomisiliTertanggung').val());
			}
			
			


		});
			
		
		
		$('input[type=radio][name=jenisKelamin]').change(function() {
			if($('#input-hubungan-0').is(':checked')){
				isiTertanggung();
				$('#clearkan').val('0');
			}else{
				clearTertanggung();
				$('#clearkan').val('1');
			}
		});
		
		
		$('input[type=radio][name=hubungan]').change(function() {
			if (this.value == '0') {
				isiTertanggung();
				$('#clearkan').val('0');
			}else{
				clearTertanggung();
				$('#clearkan').val('1');
			}
		});
		
		$('#tanggalLahir').blur(function(){
				if($('#input-hubungan-0').is(':checked')){
					isiTertanggung();
					$('#clearkan').val('0');
				}else{
					clearTertanggung();
					$('#clearkan').val('1');
				}
			});

			
			
		
		$('#tanggalLahirTertanggung').blur(function(){
				var arr1 = $('#tanggalLahirTertanggung').val();
				var arr2 = arr1.split('-');
				cekumur(new Date(arr2[0], arr2[1], arr2[2]));
			});
		
		
		$('#input-jenisKelaminTertanggung-0').blur(
		function(){
			var arr1 = $('#tanggalLahirTertanggung').val();
			var arr2 = arr1.split('-');
			cekumur(new Date(arr2[0], arr2[1], arr2[2]));
		}
		);
		
		$('#input-jenisKelaminTertanggung-1').blur(
		function(){
			var arr1 = $('#tanggalLahirTertanggung').val();
			var arr2 = arr1.split('-');
			cekumur(new Date(arr2[0], arr2[1], arr2[2]));
		}
		);
		
	
	
	
		$('#input-pencetakanPolis-0').click(function() {
				swal({
				  title: "Cetak Polis",
				  text: "Permintaan pencetakan polis akan dikenakan biaya sebesar Rp. 150.000!",
				  icon: "success",
				  button: "Aww yiss!",
				});
		});
		

JS;
$this->registerJs($script);
?>
<script>

	
	
	function hh(){
			$('#alamatDomisili').val($('#alamatSesuaiIdentitas').val());
			var newOption = $("<option selected='selected'></option>").val($('#provinsi').val()).text($('#provinsi').val())
			$("#provinsiDomisili").append(newOption).trigger('change');
			var newKota = $("<option selected='selected'></option>").val($('#kota').val()).text($('#kota').val())
			$("#kotaDomisili").append(newKota).trigger('change');
			var newKecamatan = $("<option selected='selected'></option>").val($('#kecamatan').val()).text($('#kecamatan').val())
			$("#kecamatanDomisili").append(newKecamatan).trigger('change');
			var newKelurahan = $("<option selected='selected'></option>").val($('#kelurahan').val()).text($('#kelurahan').val())
			$("#kelurahanDomisili").append(newKelurahan).trigger('change');
			$('#RWDomisili').val($('#RW').val());
			$('#RTDomisili').val($('#RT').val());
			$('#kodeposDomisili').val($('#kodepos').val());
			
			
			
			console.log($('#kota').val());
			console.log($('#kecamatan').val());
			console.log($('#kelurahan').val());
			console.log($('#kodepos').val());
			
		}


	function hh_t(){
			$('#alamatDomisiliTertanggung').val($('#alamatSesuaiIdentitasTertanggung').val());
			var newOption = $("<option selected='selected'></option>").val($('#provinsiTertanggung').val()).text($('#provinsiTertanggung').val())
			$("#provinsiDomisiliTertanggung").append(newOption).trigger('change');
			var newKota = $("<option selected='selected'></option>").val($('#kotaTertanggung').val()).text($('#kotaTertanggung').val())
			$("#kotaDomisiliTertanggung").append(newKota).trigger('change');
			var newKecamatan = $("<option selected='selected'></option>").val($('#kecamatanTertanggung').val()).text($('#kecamatanTertanggung').val())
			$("#kecamatanDomisiliTertanggung").append(newKecamatan).trigger('change');
			var newKelurahan = $("<option selected='selected'></option>").val($('#kelurahanTertanggung').val()).text($('#kelurahanTertanggung').val())
			$("#kelurahanDomisiliTertanggung").append(newKelurahan).trigger('change');
			$('#RWDomisiliTertanggung').val($('#RWTertanggung').val());
			$('#RTDomisiliTertanggung').val($('#RTtertanggung').val());
			$('#kodeposDomisiliTertanggung').val($('#KodePosTertanggung').val());
			
			
			
		}

	function cekumur(dob){
		// alert(dob);
		$('#khususanak').hide(500);
		$('#khususdewasa').hide(500);
		$('.khususpriadewasa').hide(500);
		var diff_ms = Date.now() - dob.getTime();
		var age_dt = new Date(diff_ms); 
  
		var umur = Math.abs(age_dt.getUTCFullYear() - 1970);
		
		if(parseInt(umur)<5 || parseInt(umur)>55){
			swal({
				html:true,
				title: 'PERHATIKAN UMUR TERTANGGUNG!',
				text: 'Maaf, Usia yang Anda masukkan tidak memenuhi kriteria untuk produk ini...',
				type: 'error',
				timer: 8000,
				showCancelButton: false,
				showConfirmButton: true
			});
			$('#tanggalLahirTertanggung').val('');
		}else{
			if(parseInt(umur)>4 && parseInt(umur)<13){
				// if(parseInt(umur)<13){
					$('#khususanak').show(500);
					$('#khususdewasa').hide(500);
					$('.khususwanita').hide(500);
					$('.khususpriadewasa').hide(500);
				// }
			}else if(parseInt(umur)>=20){
				/*khusus pria dewasa*/
				$('#khususdewasa').show(500);
				$('#khususdewasa').css({ width: '100%', height: 'auto' });

				
				if($('#input-jenisKelaminTertanggung-0').is(':checked')){
					// alert('Laki-Laki Tertanggung');
					$('.khususpriadewasa').show(500);
					$('.khususwanita').hide(500);
				}else{
					$('.khususpriadewasa').hide(500);
					$('.khususwanita').show(500);
				}
			}
			
		}
		
	}
	
	
	function isiTertanggung(){
		$('#namaLengkapTertanggung').val($('#fullname').val());
			$('#nomorKartuIdentitasTertanggung').val($('#nomorKartuIdentitas').val());
			$('#tempatLahirTertanggung').val($('#tempatLahir').val());
			$('#tanggalLahirTertanggung').val($('#tanggalLahir').val());
			$('#tanggalLahirTertanggung').trigger('blur');
			
			$('#uploadKtpTertanggung_uploadName').val($('#uploadKtp_uploadName').val());
			$('#uploadKtpTertanggung').val($('#uploadKtp').val());
			$('#uploadKKTertanggung_uploadName').val($('#uploadKK_uploadName').val());
			$('#uploadKKTertanggung').val($('#uploadKK').val());
			
			if($('#input-jenisKelamin-0').is(':checked')){
				$('#input-jenisKelaminTertanggung-0').prop('checked',true);
			}else if($('#input-jenisKelamin-1').is(':checked')){
				$('#input-jenisKelaminTertanggung-1').prop('checked',true);
			}
			
			if($('#input-statusPerkawinan-0').is(':checked')){
				$('#input-statusPerkawinanTertanggung-0').prop('checked',true);
			}else if($('#input-statusPerkawinan-1').is(':checked')){
				$('#input-statusPerkawinanTertanggung-1').prop('checked',true);
			}else if($('#input-statusPerkawinan-2').is(':checked')){
				$('#input-statusPerkawinanTertanggung-2').prop('checked',true);
			}
			
			if($('#input-pekerjaan-0').is(':checked')){
				$('#input-pekerjaanTertanggung-0').prop('checked',true);
			}else if($('#input-pekerjaan-1').is(':checked')){
				$('#input-pekerjaanTertanggung-1').prop('checked',true);
			}else if($('#input-pekerjaan-2').is(':checked')){
				$('#input-pekerjaanTertanggung-2').prop('checked',true);
			}else if($('#input-pekerjaan-3').is(':checked')){
				$('#input-pekerjaanTertanggung-3').prop('checked',true);
			}else if($('#input-pekerjaan-4').is(':checked')){
				$('#input-pekerjaanTertanggung-4').prop('checked',true);
			}else if($('#input-pekerjaan-5').is(':checked')){
				$('#input-pekerjaanTertanggung-5').prop('checked',true);
			}else if($('#input-pekerjaan-6').is(':checked')){
				$('#input-pekerjaanTertanggung-6').prop('checked',true);
			}
			
			
			$('#handphoneDomisiliTertanggung').val($('#handphone').val());
			$('#teleponDomisiliTertanggung').val($('#telepon').val());
			$('#emailDomisiliTertanggung').val($('#email').val());
			$('#bidangUsahaTertanggung').val($('#bidangUsaha').val());
			$('#jabatanTertanggung').val($('#jabatan').val());
			$('#namaInstitusiTempatKerjaTertanggung').val($('#namaInstitusiTempatKerja').val());
			$('#alamatinstitusiTertanggung').val($('#alamatinstitusi').val());
			
			$('#alamatSesuaiIdentitasTertanggung').val($('#alamatSesuaiIdentitas').val());
			$('#alamatDomisiliTertanggung').val($('#alamatSesuaiIdentitas').val());
			
			var newOptiont = $("<option selected='selected'></option>").val($('#provinsi').val()).text($('#provinsi').val())
			$("#provinsiTertanggung").append(newOptiont).trigger('change');
			
			var newOption = $("<option selected='selected'></option>").val($('#provinsi').val()).text($('#provinsi').val())
			$("#provinsiDomisiliTertanggung").append(newOption).trigger('change');
			
			var newOptionp = $("<option selected='selected'></option>").val($('#provinsi').val()).text($('#provinsi').val())
			$("#provinsiInstitusiTertanggung").append(newOptionp).trigger('change');
			
			var newKotat = $("<option selected='selected'></option>").val($('#kota').val()).text($('#kota').val())
			$("#kotaTertanggung").append(newKotat).trigger('change');
			
			var newKota = $("<option selected='selected'></option>").val($('#kota').val()).text($('#kota').val())
			$("#kotaDomisiliTertanggung").append(newKota).trigger('change');
			
			var newKotap = $("<option selected='selected'></option>").val($('#kota').val()).text($('#kota').val())
			$("#kotaInstitusiTertanggung").append(newKotap).trigger('change');
			
			var newKecamatant = $("<option selected='selected'></option>").val($('#kecamatan').val()).text($('#kecamatan').val())
			$("#kecamatanTertanggung").append(newKecamatant).trigger('change');
			
			
			var newKecamatan = $("<option selected='selected'></option>").val($('#kecamatan').val()).text($('#kecamatan').val())
			$("#kecamatanDomisiliTertanggung").append(newKecamatan).trigger('change');
			
			var newKecamatanp = $("<option selected='selected'></option>").val($('#kecamatan').val()).text($('#kecamatan').val())
			$("#kecamatanInstitusiTertanggung").append(newKecamatanp).trigger('change');
			
			var newKelurahant = $("<option selected='selected'></option>").val($('#kelurahan').val()).text($('#kelurahan').val())
			$("#kelurahanTertanggung").append(newKelurahant).trigger('change');
			
			var newKelurahan = $("<option selected='selected'></option>").val($('#kelurahan').val()).text($('#kelurahan').val())
			$("#kelurahanDomisiliTertanggung").append(newKelurahan).trigger('change');
			
			var newKelurahanp = $("<option selected='selected'></option>").val($('#kelurahan').val()).text($('#kelurahan').val())
			$("#kelurahanInstitusiTertanggung").append(newKelurahanp).trigger('change');
			
			$('#RWTertanggung').val($('#RW').val());
			$('#RWDomisiliTertanggung').val($('#RW').val());
			$('#RWInstitusiTertanggung').val($('#RWInstitusi').val());
			
			$('#RTtertanggung').val($('#RT').val());
			$('#RTDomisiliTertanggung').val($('#RT').val());
			$('#RTInstitusiTertanggung').val($('#RTInstitusi').val());
			
			$('#KodePosTertanggung').val($('#kodepos').val());
			$('#kodeposDomisiliTertanggung').val($('#kodepos').val());
			$('#kodePosInstitusiTertanggung').val($('#kodePosInstitusi').val());
			$('#teleponInstitusiTertanggung').val($('#teleponInstitusi').val());
			
			
			/*cek pria dewasa*/
			var arr1 = $('#tanggalLahirTertanggung').val();
			var arr2 = arr1.split('-');
			cekumur(new Date(arr2[0], arr2[1], arr2[2]));
	}
	
	
	function clearTertanggung(){

		if($('#clearkan').val()=='0'){
			$('#namaLengkapTertanggung').val('');
				$('#nomorKartuIdentitasTertanggung').val('');
				$('#tempatLahirTertanggung').val('');
				$('#tanggalLahirTertanggung').val('');
				$('#input-jenisKelaminTertanggung-0').prop('checked',false);
				$('#input-jenisKelaminTertanggung-1').prop('checked',false);
				$('#input-statusPerkawinanTertanggung-0').prop('checked',true);
				$('#input-statusPerkawinanTertanggung-1').prop('checked',true);
				$('#input-statusPerkawinanTertanggung-2').prop('checked',true);
				$('#handphoneDomisiliTertanggung').val('');
				$('#teleponDomisiliTertanggung').val('');
				$('#emailDomisiliTertanggung').val('');
				$('#pekerjaanTertanggung').val('');
				$('#bidangUsahaTertanggung').val('');
				$('#jabatanTertanggung').val('');
				$('#namaInstitusiTempatKerjaTertanggung').val('');
				$('#alamatinstitusiTertanggung').val('');
				
				$('#alamatSesuaiIdentitasTertanggung').val('');
				$('#alamatDomisiliTertanggung').val('');
				
				$("#provinsiTertanggung").val('');
				$("#provinsiTertanggung").trigger('change');
				
				$("#provinsiDomisiliTertanggung").val('');
				$("#provinsiDomisiliTertanggung").trigger('change');
				
				$("#provinsiInstitusiTertanggung").val('');
				$("#provinsiInstitusiTertanggung").trigger('change');
				
				$("#kotaTertanggung").val('');
				$("#kotaTertanggung").trigger('change');
				
				$("#kotaDomisiliTertanggung").val('');
				$("#kotaDomisiliTertanggung").trigger('change');
				
				$("#kotaInstitusiTertanggung").val('');
				$("#kotaInstitusiTertanggung").trigger('change');
				
				$("#kecamatanTertanggung").val('');
				$("#kecamatanTertanggung").trigger('change');
				
				$("#kecamatanDomisiliTertanggung").val('');
				$("#kecamatanDomisiliTertanggung").trigger('change');
				
				$("#kecamatanInstitusiTertanggung").val('');
				$("#kecamatanInstitusiTertanggung").trigger('change');
				
				$("#kelurahanTertanggung").val('');
				$("#kelurahanTertanggung").trigger('change');
				
				$("#kelurahanDomisiliTertanggung").val('');
				$("#kelurahanDomisiliTertanggung").trigger('change');
				
				$("#kelurahanInstitusiTertanggung").val('');
				$("#kelurahanInstitusiTertanggung").trigger('change');
				
				$('#RWTertanggung').val('');
				$('#RWDomisiliTertanggung').val('');
				$('#RWInstitusiTertanggung').val('');
				
				$('#RTtertanggung').val('');
				$('#RTDomisiliTertanggung').val('');
				$('#RTInstitusiTertanggung').val('');
				
				$('#KodePosTertanggung').val('');
				$('#kodeposDomisiliTertanggung').val('');
				$('#kodePosInstitusiTertanggung').val('');
				$('#teleponInstitusiTertanggung').val('');
				
				$('#uploadKtpTertanggung_uploadName').val('');
				$('#uploadKtpTertanggung').val('');
				$('#uploadKKTertanggung_uploadName').val('');
				$('#uploadKKTertanggung').val('');
				
				$('#input-statusPerkawinanTertanggung-0').prop('checked',false);
				$('#input-statusPerkawinanTertanggung-1').prop('checked',false);
				$('#input-statusPerkawinanTertanggung-2').prop('checked',false);
				
				/*cek pria dewasa*/
				$('.khususpriadewasa').hide(500);
				$('.khususwanita').hide(500);
			
		}
	}
		

</script>
