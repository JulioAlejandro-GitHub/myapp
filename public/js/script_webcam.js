


const video = document.getElementById('inputVideo1');
const canvas = document.getElementById('overlay1');
//const image = document.getElementById('image');

let PesonasIdentificadas;
let faceMatcher;

let VisitaIdentificada = [];


(async () => {
  /*
  de que campara es ?
  identificar origen
  (hay tres tipos de camaras: entrada, interna, salida)
  de que local y ubicacion???
  id de la camara y local
  */
  const stream = await navigator.mediaDevices.getUserMedia({ video: {} });
  video.srcObject = stream;
})();

async function onStart() {
  const MODEL_URL = './public/models';
  await faceapi.loadSsdMobilenetv1Model(MODEL_URL)
  await faceapi.loadFaceLandmarkModel(MODEL_URL)
  await faceapi.loadFaceRecognitionModel(MODEL_URL)
  await faceapi.loadFaceExpressionModel(MODEL_URL)

  PesonasIdentificadas = await F_PesonasIdentificadas();//debe cargar solo una ves
  faceMatcher = new faceapi.FaceMatcher(PesonasIdentificadas, 0.6);

  FaceDetec();
}

async function FaceDetec() {
  let fullFaceDetections = await faceapi.detectAllFaces(video)
    .withFaceLandmarks()
    .withFaceDescriptors()
  // .withFaceExpressions();

  console.log('fullFaceDetections', fullFaceDetections);

  if (fullFaceDetections.length <= 0) {
    //setTimeout( ()=>FaceDetec(),100);
    //return false;
  } else {
    //const resizedResults   = await drawResult(canvas, video, fullFaceDetections);
    //const detectionResults = fullFaceDetections.map(d => faceMatcher.findBestMatch(d.descriptor))

  fullFaceDetections.map(async function(element){


      console.log('element descriptor ****', element.descriptor);
      const detectionResults2 = faceMatcher.findBestMatch(element.descriptor)
      console.log('detectionResults2.forEach ', detectionResults2);

      console.log('element detection ****', element.detection);
      let { _box: box } = element.detection;
      let region = await new faceapi.Rect(box._x, box._y, box._width, box._height);
      let faces  = await faceapi.extractFaces(video, [region]);
      if (faces.length > 0) {
        faces.forEach(cnv => {//cada cara encontrada
          putImgUrl(cnv.toDataURL("image/jpeg", 1.0),`${detectionResults2._label}.jpg`)
        })
      }


      if (detectionResults2._label == 'unknown') {
        console.log('visita no idenificada');
        //visita no idenificada
        //hacer foto y crear directorio
        //agregar entrada (hay tres tipos de camaras: entrada, interna, salida)
        //segun el origen registrar la accion
      } else {
        if (VisitaIdentificada.find(element => element == detectionResults2._label)) {
          console.log(detectionResults2._label, ' ya pasoooooooo');
        } else {
          console.log(detectionResults2._label, ' registrar ingreso * estadia * egreso');
          VisitaIdentificada.push(detectionResults2._label)
        }

        //buscar el nombre en BD
        //registrar ingreso, estadia, egreso:: in, on, out
      }
  });
    
    

/*
    let { _box: box } = fullFaceDetections[0].detection;
    let region = await new faceapi.Rect(box._x, box._y, box._width, box._height);
    let faces  = await faceapi.extractFaces(video, [region]);
    console.log('faces****', faces);

    if (faces.length > 0) {
      faces.forEach(cnv => {//cada cara encontrada
        putImgUrl(cnv.toDataURL("image/jpeg", 1.0),'ggggggg.jpg')
      })
    }
    */
    

    /*
    detectionResults.forEach((result, i) => {
      console.log('detectionResults.forEach ', result);

      if (true) { //dibujar???
        //const box = resizedResults[i].detection.box
        //const drawBox = new faceapi.draw.DrawBox(box, { label: result.toString() })
        //drawBox.draw(canvas)
      }
      if (result._label == 'unknown') {
        console.log('visita no idenificada');
        //visita no idenificada
        //hacer foto y crear directorio
        //agregar entrada (hay tres tipos de camaras: entrada, interna, salida)
        //segun el origen registrar la accion
      } else {
        if (VisitaIdentificada.find(element => element == result._label)) {
          console.log(result._label, ' ya pasoooooooo');
        } else {
          console.log(result._label, ' registrar ingreso * estadia * egreso');
          VisitaIdentificada.push(result._label)
        }

        //buscar el nombre en BD
        //registrar ingreso, estadia, egreso:: in, on, out
      }
    })
    */
    
  }

  //setTimeout( ()=>FaceDetec(),2000);
}


function putImgUrl(Data,Name) {
  $.post( "./app/comun/savepng.php", { 
    imgData:Data,
    imgName: Name
  })
  .done(function( response ) {
    $("#resultado").html(response);
  })
  .fail(function() {
    $("#resultado").html("error");
  });
}


/*
let outputImage = document.getElementById('outputImage'); // si quiere mostrar img
// This function extract a face from video frame with giving bounding box and display result into outputimage
async function extractFaceFromBox(inputImage, box) {
  const regionsToExtract = [
    new faceapi.Rect(box.x, box.y, box.width, box.height)
  ]
  let faceImages = await faceapi.extractFaces(inputImage, regionsToExtract)
  if (faceImages.length == 0) {
    console.log('Face not found')
  } else {
    faceImages.forEach(cnv => {
      console.log('$$$$$$$$$$$$$$$cnv.toDataURL();', cnv.toDataURL("image/jpeg", 1.0));
      outputImage.src = cnv.toDataURL("image/jpeg", 1.0);
    })
  }
  //downloadImage(outputImage.src);
}
*/




async function drawResult(canvas, video, fullFaceDetections) {
  const dims = faceapi.matchDimensions(canvas, video, true);
  const resizedResults = faceapi.resizeResults(fullFaceDetections, dims);
  //faceapi.draw.drawDetections(canvas, resizedResults);
  //faceapi.draw.drawFaceLandmarks(canvas, resizedResults);
  //faceapi.draw.drawFaceExpressions(canvas, resizedResults);
  return resizedResults;
}
async function F_PesonasIdentificadas(type) {
  const imgPersonsDirectori = 5;
  let filePath = `./labeled_images/`;
  let sujetos = ['Cris', 'Julio', 'Pepa', 'Gabi']
  if (type == 'Confianza') {

  }
  if (type == 'Hostil') {

  }
  return Promise.all(
    sujetos.map(async label => {

      const descriptions = []
      for (let i = 1; i <= imgPersonsDirectori; i++) {
        let fileImg = `${filePath}${label}/${i}.jpg`;
        /*
        solo si existe la imagen en disco
        */
        const img = await faceapi.fetchImage(fileImg)
        const fullFaceDescription = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor()
        if (fullFaceDescription) {
          descriptions.push(fullFaceDescription.descriptor)
        }
      }
      return new faceapi.LabeledFaceDescriptors(label, descriptions)
    })
  )
}