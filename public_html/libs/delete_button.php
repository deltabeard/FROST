<?php
/**
 * @param $id button will be linked to video with this id
 * @return string containing HTML for showing a delete button linked to a video
 */
function print_delete_button($id){
    // Print delete button
    return "<a id='" . $id . "_delete_button" . "' href='#' onclick='showRmvOpt(" . $id . ");return false;' class='button'>Delete</a>";
}