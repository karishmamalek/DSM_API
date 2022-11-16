<?php
/**
 * FUNCTION FOR JSON RESPONSE
*/
function jsonResponse($resCode,$resMessage,$response){
    return response()->json([
        'status_code' => $resCode,
        'message' => $resMessage,
        'data' =>$response
    ]);
}
?>