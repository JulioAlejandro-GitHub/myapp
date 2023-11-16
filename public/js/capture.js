const video = document.getElementById('video')
const MODEL_URL = './public/models';
Promise.all([
    
  faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
  faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
  faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL),
  faceapi.nets.faceExpressionNet.loadFromUri(MODEL_URL),
  faceapi.nets.ssdMobilenetv1.loadFromUri(MODEL_URL)
]).then(startVideo)

function startVideo() {
  // navigator.getUserMedia(
  //   { video: {} },
  //   stream => video.srcObject = stream,
  //   err => console.error(err)
  // )

  navigator.getUserMedia = navigator.getUserMedia ||
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia;

  if (navigator.getUserMedia) {
    navigator.getUserMedia({ audio: false, video: {} },
        function(stream) {
          var video = document.querySelector('video');
          video.srcObject = stream;
          video.onloadedmetadata = function(e) {
            video.play();
          };
        },
        function(err) {
          console.log("The following error occurred: " + err.name);
        }
    );
  } else {
    console.log("getUserMedia not supported");
  }
}

video.addEventListener('play', () => {
    const canvas = faceapi.createCanvasFromMedia(video)
    //document.body.append(canvas)
    const area = document.getElementById('container')
    area.append(canvas)
    const displaySize = { width: video.width, height: video.height }
    faceapi.matchDimensions(canvas, displaySize)
    setInterval(async () => {
        const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions()
        const count = await faceapi
            .detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
            .withFaceLandmarks()
        if(count.length>1){
            alert("There are multiple faces in the frame. Please keep only one face");
        }
        else{
            const resizedDetections = faceapi.resizeResults(detections, displaySize)
console.log('detections',detections);


            canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)

            //faceapi.draw.drawDetections(canvas, resizedDetections)
            //faceapi.draw.drawFaceLandmarks(canvas, resizedDetections)
            //faceapi.draw.drawFaceExpressions(canvas, resizedDetections)

            // console.log(resizedDetections[0].detection._box._height)
            // console.log(resizedDetections[0].detection._box._width)
            // console.log(resizedDetections[0].detection._box._x)
            // console.log(resizedDetections[0].detection._box._y)

            var frame_height = detections[0].detection._box._height
            var frame_width = detections[0].detection._box._width
            var frame_x = detections[0].detection._box._x
            var frame_y = detections[0].detection._box._y

            const button = document.getElementById('button')

            if (((frame_height>=160 && frame_height<=270) && (frame_width>=180 && frame_width<=270)) &&
                ((frame_x>=100 && frame_x<=195) && (frame_y>=80 && frame_y<=190)))
            {
              button.disabled = false
              button.onclick = async function(){
              button.disabled = true
              await CaptureImage()
            };
            }

            else{
                button.disabled = true
            }
        }
    }, 10000)
})

async function CaptureImage(){
  document.querySelectorAll("#screenshot img")
  .forEach(img => img.remove());

  const canvas = document.createElement('canvas');
  canvas.width = 239;
  canvas.height = 306;

  canvas.getContext('2d').drawImage(video, 0, 0, 239, 306);
  //canvas.getContext('2d').drawImage(video, 169, 47, 306, 392, 0, 0, 306, 392);

  //const img = document.createElement("img");

  const img = new Image()

  img.src = canvas.toDataURL('image/png', 1.0)

  //document.getElementById('picture').src= img.src
  document.getElementById('screenshot').appendChild(img)

  
  const detections = await faceapi.detectAllFaces(img, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions()
  
}