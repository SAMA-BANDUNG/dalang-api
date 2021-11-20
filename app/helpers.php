<?php
if (!function_exists('storeFileToPublic')) {
    function storeFileToPublic($uploadedImage, $user_id, $folder): String
    {
        $imgName = date('dmyHis') . rand(00, 99) . '.' . $uploadedImage->extension();
        $path = 'storage/assets/'. $user_id .'/' . $folder;
        $uploadedImage->move($path, $imgName);

        return $path . '/' . $imgName;
    }
}

if (!function_exists('pushNotifFcm')) {
    function pushNotifFcm($target, $title, $message)
    {
        if ($target == null) {
            return false;
        }

        $data = array(
            'title' => $title,
            'body' => $message,
        );

        $fields = array(
            'to' => $target,
            'data' => $data,
            'android' => array(
                'priority' => 'high'
            )
        );

        $headers = array(
            'Authorization: key=AAAAU30s1gE:APA91bFkGs9y_bX0-Y0fiyjm5FJyTlDs5CgDPEQLM3gErUHZhcrWf8wozEsXlMMVqf6SLevxfDOC7jbqk3RnxFUPtAxwfg3-9XOH2EJZnEGXmk5I2Cf6CXpxN1UHt2K82CmNIZBa_VB_',
            'Content-Type: application/json'
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        
        curl_close($ch);
        
        return json_decode($result);
    }
}
