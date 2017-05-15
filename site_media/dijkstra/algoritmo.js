
/**
 * Basic priority queue implementation. If a better priority queue is wanted/needed,
 * this code works with the implementation in google's closure library (https://code.google.com/p/closure-library/).
 * Use goog.require('goog.structs.PriorityQueue'); and new goog.structs.PriorityQueue()
 */
var result;

function identify(lat, lng) {
  $.getJSON('../site_media/data/nodes.geojson', 'path=1', nodes);
  function nodes(rel) {
    var suma = [];
    var aux = 0;
    var nodeLat = [];
    for (var i = 0; i <= 1; i++) {
      //suma[i]= lat[i] - rel.osm.node[0]._lat;
      suma[i] = 9999999999;
      for (var j = 0; j <= rel.osm.node.length - 1; j++) {
        aux = calcDistance(lat[i], rel.osm.node[j]._lat, lng[i], rel.osm.node[j]._lon);
        if (aux < suma[i]) {

          suma[i] = aux;
          nodeLat[i] = j;
          //console.log("..((:..." + nodeLat[i]);
        }
      }
    }
    var start = rel.osm.node[nodeLat[0]]._id.toString();
    var finish = rel.osm.node[nodeLat[1]]._id.toString();
    console.log("suma: " + suma[0] + " en nodelat " + nodeLat[0] + " referencia: " + rel.osm.node[nodeLat[0]]._id);
    console.log("suma: " + suma[1] + " en nodelat " + nodeLat[1] + " referencia: " + rel.osm.node[nodeLat[1]]._id);
    //console.log(lat[i] + "---------" + lng[i]);
    calc(start, finish);
  }


}

function calcDistance(x1, x2, y1, y2) {
  var dist = Math.sqrt(Math.pow((x1 - x2), 2) + Math.pow((y1 - y2), 2)) * 100;
  return dist.toFixed(2);
  //console.log("distancia de " + dist.toFixed(2) + " km");
  //console.log(dist.toFixed(5)*1000);
}

function calcDistance2(x1, x2, y1, y2) {
  var dist = Math.sqrt(Math.pow((x1 - x2), 2) + Math.pow((y1 - y2), 2)) * 100;
  return dist;

}


/*var point = [];
function readNodes(rel) {
  for (var i = 0; i <= result.length - 1; i++) { //Largo como vias hay
    for (var j = 0; j <= rel.osm.node.length - 1; j++) {
      if (rel.osm.node[j]._id == result[i]) {

        x = rel.osm.node[j]._lat;
        y = rel.osm.node[j]._lon;
      }
    }
  }
}*/

function calc(start, finish) {

  function PriorityQueue() { //Clase JS
    this._nodes = []; //atributo

    this.enqueue = function (priority, key) {
      this._nodes.push({ key: key, priority: priority }); //Adds a new item to an array:
      this.sort(); //ordena
    };
    this.dequeue = function () { //remove from queue
      return this._nodes.shift().key; //Remove the first item of an array:
    };
    this.sort = function () {
      this._nodes.sort(function (a, b) {
        return a.priority - b.priority;
      });
    };
    this.isEmpty = function () {
      return !this._nodes.length;
    };
  }

  /**
   * Pathfinding starts here
   */
  function Graph() {
    var INFINITY = 1 / 0; //No es que sea infinito, sino que es undefined
    this.vertices = {}; //instanciacion

    this.addVertex = function (name, edges) {
      this.vertices[name] = edges;
    };

    this.shortestPath = function (start, finish) {
      var nodes = new PriorityQueue(), //crea objeto
        distances = {},
        previous = {},
        path = [],
        smallest, vertex, neighbor, alt;

      for (vertex in this.vertices) { //Inicializamos el valor del vertice
        if (vertex === start) {
          distances[vertex] = 0;
          nodes.enqueue(0, vertex);
        }
        else {
          distances[vertex] = INFINITY;
          nodes.enqueue(INFINITY, vertex);
        }

        previous[vertex] = null;
      }

      while (!nodes.isEmpty()) { //mientras nodo no esté vacio
        smallest = nodes.dequeue();

        if (smallest === finish) { //0LE
          path = [];

          while (previous[smallest]) {
            path.push(smallest);
            smallest = previous[smallest];
          }

          break; //Salir del programa?
        }

        if (!smallest || distances[smallest] === INFINITY) {
          continue;
        }

        for (neighbor in this.vertices[smallest]) {
          alt = distances[smallest] + this.vertices[smallest][neighbor];

          if (alt < distances[neighbor]) {
            distances[neighbor] = alt;
            previous[neighbor] = smallest;

            nodes.enqueue(alt, neighbor);
          }
        }
      }

      return path;
    };
  }
  var g = new Graph();





  /*Aqui antes faltaría procesar el geoJSON para calcular la ruta
  con las coordenadas reales*/

  g.addVertex('3177282627', { 3177282626: 33.02 });
  g.addVertex('3177282626', { 4706019940: 57.58, 3177282627: 33.02, 1031040305: 4.42 });
  g.addVertex('1031040305', { 4706019940: 57.58, 3177282627: 33.02, 3177282626: 4.42 });
  g.addVertex('4706019940', { 3177282626: 57.58, 1031040323: 33.19, 4706019941: 88.63 });
  g.addVertex('4706019941', { 4706019940: 88.63, 4706019942: 20.19, 4706019945: 35.94 });
  g.addVertex('1031040323', { 4706019940: 33.19, 1031038644: 48.23, 1031040330: 49.54, 2308473530: 72.56 });
  g.addVertex('1031040330', { 1031040323: 49.54, 1031040335: 47.96, 4706019945: 36.71 });
  g.addVertex('4706019945', { 1031040330: 36.71, 4706019941: 35.94, 1031038659: 35.06 });
  g.addVertex('1031038644', { 1031040323: 48.23, 1031040335: 46.91, 1031040321: 68.57 });
  g.addVertex('1031040335', { 1031038644: 46.91, 1031040330: 47.96, 1031040327: 38.73 });
  g.addVertex('1031040327', { 4539880678: 34.92, 1031040318: 71.44, 1031040335: 38.73 });
  g.addVertex('1031040339', { 1031038659: 47.33, 1031040318: 39.03, 1031040335: 71.63, 2546239856: 43.9 });
  g.addVertex('1031038659', { 4706019945: 35.06, 1031040339: 47.33, 2546239855: 43.97 });
  g.addVertex('2308473530', { 1031040323: 72.56, 4706019946: 47.75, 1031040314: 64.33 });
  g.addVertex('1031040314', { 2308473530: 64.33, 4706019947: 46.85, 1031040302: 45.11 });
  g.addVertex('1031040302', { 1031040314: 45.11, 4539880707: 94.869, 4539880694: 103.59, 4539880704: 42.77 });
  g.addVertex('4539880707', { 1031040302: 94.869, 4539880708: 52.839 });
  g.addVertex('4539880708', { 4539880707: 52.839 });
  g.addVertex('4539880704', { 4539880709: 98.77, 4706019923: 103.32, 999: 45.11 });
  g.addVertex('4706019947', { 1031040314: 46.85, 4706019946: 64.39, 1031040337: 69.63 });
  g.addVertex('4539880709', { 4539880704: 98.77, 1031038723: 127.41, 4539880710: 89.21 });
  g.addVertex('1031038723', { 4539880709: 127.41, 248033115: 21.27 });
  g.addVertex('248033115', { 1031038723: 21.27 });
  g.addVertex('4539880710', { 4539880709: 89.21, 4706019923: 95.10 });
  g.addVertex('4706019923', { 4539880710: 95.10, 4539880704: 103.32, 248033119: 33.57 });
  g.addVertex('248033119', { 4706019923: 33.57, 4539880693: 10.47 });
  g.addVertex('4539880693', { 248033119: 10.47, 4539880692: 12.66 });
  g.addVertex('4539880692', { 4539880694: 13.16, 4539880693: 12.66, 4539880698: 12.1 });
  g.addVertex('4539880694', { 4539880692: 13.16, 1031040302: 103.59 });
  g.addVertex('4539880698', { 4539880692: 12.1, 1031040337: 22.8 });
  g.addVertex('1031040337', { 4539880698: 22.8, 4706019947: 69.63, 2308473580: 50.14 });
  g.addVertex('2308473580', { 1031040337: 50.14, 2308473575: 14.14, 2308473616: 58.61 });
  g.addVertex('2308473616', { 2308473580: 58.61, 2308473538: 36.61, 3655661643: 46.36 });
  g.addVertex('2308473575', { 2308473580: 14.14, 4706019946: 67.9, 3655661642: 33.61 });
  g.addVertex('1031040321', { 1031038644: 68.57, 3655661642: 37.93, 1031038720: 8.88 });
  g.addVertex('3655661642', { 1031040321: 37.93, 3655661643: 57.35, 2308473575: 33.61 });
  g.addVertex('1031038720', { 1031040321: 8.88, 1031038749: 47.48, 4539880678: 33.01 });
  g.addVertex('4539880678', { 1031038720: 33.01, 1031040327: 34.92, 1031038749: 27.40, 1031040307: 71.48 });
  g.addVertex('1031040318', { 1031040339: 39.03, 1031038674: 96.29, 1031040327: 71.44, 1031040307: 37.90 });
  g.addVertex('1031040307', { 1031040318: 37.90, 4539880678: 71.48, 1031040316: 77.69, 1031038754: 95.60 });
  g.addVertex('1031040316', { 1031040307: 77.69, 1031038702: 45.58, 1031046167: 93.86 });
  g.addVertex('1031038702', { 1031040316: 45.58, 1031038749: 53.37, 1455074027: 93.2 });
  g.addVertex('2546239855', { 2546239856: 37.62, 1031038659: 43.97, 4539880654: 28.40 });
  g.addVertex('2546239856', { 2546239855: 37.62, 1031046161: 52.04, 1031040339: 43.9 });
  g.addVertex('4539880654', { 2546239855: 28.40, 4539880656: 8.319, 4706019944: 17.4 });
  g.addVertex('4539880656', { 4539880654: 8.319, 1031046180: 14.67, 4539880658: 74.16 });
  g.addVertex('1031046180', { 4539880656: 14.67, 1031046161: 22.34, 1474923298: 71.49 });
  g.addVertex('1031046161', { 1031046180: 22.34, 2546239856: 52.04, 1031038674: 39.36 });
  g.addVertex('1031038674', { 1031046161: 39.36, 1031040318: 96.29, 1031038754: 38.629 });
  g.addVertex('1031038754', { 1031038674: 38.629, 1031040307: 95.60, 1474923296: 33.92, 1474923300: 81.63 });
  g.addVertex('1474923296', { 1031038754: 33.92, 1474923297: 31.45, 1474923306: 92.7 });
  g.addVertex('1474923297', { 1474923296: 31.45, 1031046167: 29.19, 1474923311: 100.62 });

  g.addVertex('9999999', { 99999: 64.33, 9999: 46.85, 999: 45.11 });
  // Log test, with the addition of reversing the path and prepending the first node so it's more readable
  //console.log(g.shortestPath('3177282626', '1031038659').concat(['3177282626']).reverse());
  result = g.shortestPath(start, finish).concat([start]).reverse();
  console.log(result);

  //ESTO VA A OTRO ARCHIVO LOCOOO
  $.getJSON('../site_media/data/nodes.geojson', 'path=1', drawNodes);
  var point = [];
  var distance = 0;
  function drawNodes(rel) {
    for (var i = 0; i <= result.length - 1; i++) { //Largo como vias hay
      for (var j = 0; j <= rel.osm.node.length - 1; j++) {
        if (rel.osm.node[j]._id == result[i]) {

          x = rel.osm.node[j]._lat;
          y = rel.osm.node[j]._lon;
          //console.log(i +": " + x + "-" + y);
          point[i] = new L.LatLng(x, y);
          console.log(result[i] + "coord: " + x + "-" + y);
          //if (j < result.length - 1) {
            distance = distance + (calcDistance2(x, rel.osm.node[j + 1]._lat, y, rel.osm.node[j + 1]._lon));
          //}
        }
      }
    }
    console.log("DISTANCIA DE: " + distance);
    //var pointList = [point[0], point[1], point[2], point[3], point[4], point[5], point[6]];
    var pointList = [point];
    var firstpolyline = new L.Polyline(pointList, {
      color: 'purple',
      weight: 4,
      opacity: 1,
      smoothFactor: 1
    });
    firstpolyline.addTo(mymap);
  }

  /*  var pointA = new L.LatLng(38.240, -0.820);
  var pointB = new L.LatLng(38.246, -0.820);*/


};