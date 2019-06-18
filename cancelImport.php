<?php
$project_id = $_POST['pid'];

$import_cancel = $module->getProjectSetting('import-cancel', $project_id);

$edoc_list = $module->getProjectSetting('edoc');

$edoc = array_pop(array_reverse($edoc_list));
if (($key = array_search($edoc, $edoc_list)) !== false) {
    $import = $module->getProjectSetting('import', $project_id);
    $import_number = $module->getProjectSetting('import-number', $project_id)[$key];
    if($import[$key] == false){
        $import_cancel[$key] = true;

        $module->setProjectSetting('import-cancel', $import_cancel,$project_id);

        \REDCap::logEvent("<i>Big Data Import</i> process <b>cancelled</b>\n <b>Import #".$import_number."</b>","user = ".USERID."\nFile = '".$module->getDocName($edoc)."'\nImport = ".$import_number,null,null,null,$project_id);
    }
    echo json_encode(array(
            'status' =>'success'
        )
    );
}else{
    echo json_encode(array(
        'status' => "cancel"
    ));
}
?>