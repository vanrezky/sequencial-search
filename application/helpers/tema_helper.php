<?php

function FormInputText($label="", $name="", $value='', $readonly = FALSE, $function="", $info="", $elm="", $inline_label=FALSE) {
    $lbl   = explode("|", $label);
    $label = count($lbl) > 1 ? $lbl[0]. " " . $lbl[1]:$lbl[0]; 
    $nid   = str_replace(" ", "", strtolower($lbl[0]));
    $readonly = $readonly === TRUE ? "readonly":$readonly;
    $placeholder = $lbl[0];
    $H = "";
    $H .= "<div class='form-group row'>";
    if($inline_label) {
        $H .= " <label formLabel inl class='col-form-label' for='form-field-$nid'> $label </label>"; 
        $H .= " <input name='$name' type='text' id='form-field-$nid' placeholder='$placeholder' class='form-control ' value='$value' $readonly />";
        $H .= $elm;
        if(!empty($info)) $H .= "<span class='help-block no-margin'>$info</span>"; 
    } else {
        $H .= " <label formLabel class='col-sm-4 col-form-label' for='form-field-$nid'> $label </label>";
        $H .= " <div formInput class='col-sm-8'>";
        $H .= "   <input name='$name' type='text' id='form-field-$nid' placeholder='$placeholder' class='form-control' value='$value' $readonly $function />";
        $H .= $elm;
        if(!empty($info)) $H .= "<span class='help-block no-margin'>$info</span>";
        $H .= " </div>";
    } 
    $H .= "</div>";
    return $H;
}

function FormInputNumber($label="", $name="", $value='', $readonly = FALSE, $info="", $elm="", $inline_label=FALSE) {
    $lbl   = explode("|", $label);
    $label = count($lbl) > 1 ? $lbl[0]. " " . $lbl[1]:$lbl[0]; 
    $nid   = str_replace(" ", "", strtolower($lbl[0]));
    $readonly = $readonly === TRUE ? "readonly":$readonly;
    $placeholder = $lbl[0];
    $H = "";
    $H .= "<div class='form-group row'>";
    if($inline_label) {
        $H .= " <label formLabel inl class='col-form-label' for='form-field-$nid'> $label </label>"; 
        $H .= " <input name='$name' type='tel' id='form-field-$nid' placeholder='$placeholder' class='form-control ' value='$value' $readonly />";
        $H .= $elm;
        if(!empty($info)) $H .= "<span class='help-block no-margin'>$info</span>"; 
    } else {
        $H .= " <label formLabel class='col-sm-4 col-form-label' for='form-field-$nid'> $label </label>";
        $H .= " <div formInput class='col-sm-8'>";
        $H .= "   <input name='$name' type='tel' id='form-field-$nid' placeholder='$placeholder' class='form-control' value='$value' $readonly />";
        $H .= $elm;
        if(!empty($info)) $H .= "<span class='help-block no-margin'>$info</span>";
        $H .= " </div>";
    } 
    $H .= "</div>";
    return $H;
}

function FormDropdownText($label="", $name="", $D, $value="", $tampil='', $selected=FALSE, $readonly = FALSE, $function="", $inline_label=FALSE) {
    $lbl   = explode("|", $label);
    $label = count($lbl) > 1 ? $lbl[0]. " " . $lbl[1]:$lbl[0]; 
    $nid   = str_replace(" ", "", strtolower($lbl[0])).rand(0, 100).rand(0, 100);  
    $readonly = $readonly === TRUE ? "readonly disabled":"";
    $H = "";
    $H .= "<div input='$lbl[0]' class='form-group row'>";
    if($inline_label) {
        $H .= " <label class='col-form-label' for='form-field-select-$nid'> $label </label>"; 
    } else {
        $H .= " <label class='col-sm-4 col-form-label' for='form-$nid'> $label </label>";
        $H .= " <div class='col-sm-8'>";
    } 
    $H .= "   <select name='$name' class='select2bs4' style='width: 100%;'  id='form-field-select-$nid' placeholder='Pilih $label...' $readonly data-placeholder='Pilih' >"; 
    $H .= "     <option > </option>";  
    $tampil = explode("|", $tampil);  
    if(is_array($D)) { 
        foreach ($D as $nn => $V) { 
        if(count($tampil) <= 1) { 
            $VV = $V[$tampil[0]];
        } else {
            $VV = "";
            for ($i=0; $i < count($tampil) ; $i++) { 
            if($i < count($tampil)-1) {
                $VV .= $V[$tampil[$i]]." ~ ";
            } else {
                $VV .= $V[$tampil[$i]];
            } 
            }
        }
        $attrU = is_object($function) ? $function($nn, $V):""; 
        if($selected !== FALSE AND $V[$value] == $selected) {
            $H .= "<option $attrU value='".$V[$value]."' selected >".$VV."</option>";
        } else { 
            $H .= "<option $attrU value='".$V[$value]."'>".$VV."</option>";
        } 
        } 
    } else {
        $H .= "<option> -- Data tidak sesuai -- </option>";
    } 
    $H .= "   </select>"; 
    if(!$inline_label)
        $H .= " </div>";
    $H .= "</div>";
    $H .= "<div class='clearfix' ></div>";
    return $H; 
}

function buttonDropdown($D=[]) {
    
    $H = '';
    $H .= "<button type='button' class='btn btn-default dropdown-toggle dropdown-icon' data-toggle='dropdown' aria-expanded='false'>";
    $H .= "<span class='sr-only'></span>";
    $H .= "<div class='dropdown-menu' role='menu' style=''>";
    foreach($D as $key => $value) {
        $value["attr"] = isset($value["attr"]) ? $value["attr"]:"";
        $value["link"] = isset($value["link"]) ? $value["link"]:"#";
        $value["name"] = isset($value["name"]) ? $value["name"]:"";
        $target = (isset($value['blank']) AND $value['blank'] == TRUE) ? "_blank":"_self";
        $H .= "<a $value[attr] href=\"$value[link]\" target=\"{$target}\" >$value[name]</a>";
    }
    $H .= "</div>";    
    $H .= "</button>";   

    return $H;
}