
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>


<?php 
function objectToArray ($object) {
    if(!is_object($object) && !is_array($object)){
        return $object;
    }
    return array_map('objectToArray', (array) $object);
}

$userArray = objectToArray($user);

?>
<script>
   let sessionObj = {
            email: '{{$userArray['data']['email']}}',
            full_name: '{{$userArray['data']['full_name']}}',
            token: '{{$_REQUEST['tocken']}}',
          };
    sessionStorage.setItem("loginInfo", JSON.stringify(sessionObj));
    window.location.href="https://{{$_SERVER['SERVER_NAME']}}/admin#/";
  
</script>
</html>
