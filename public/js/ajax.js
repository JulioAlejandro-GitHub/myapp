function putImg(str) {
    if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("txtHint").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "../app/comun/putImg.php?q=" + str, true);
      xmlhttp.send();
    }
  }
  
  function putImgUrl( 
        url='https://media.geeksforgeeks.org/wp-content/uploads/geeksforgeeks-6-1.png',
        nameOfDownload = 'my-image.jpg'
  ) {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("txtHint").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "../app/comun/putImg.php?url=" + url, true);
      xmlhttp.send();
  }