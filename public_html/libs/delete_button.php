<?php
/**
 * @param $id button will be linked to video with this id
 * @return string containing HTML for showing a delete button linked to a video
 */
function print_delete_button($id){
    // Print delete button
    return "<a id='delete_button_" . $id . "' href='#' onclick='showRmvOpt(" . $id . ");return false;' class='button'>Delete</a>";
}