/****************************************************************
* Random Integer function returns int between min and max values
* @param pos_neg, allows negative inversal of the random int.
****************************************************************/
function rand(min, max, pos_neg = false) {
   var d = 1;// direction
   var val = Math.floor(Math.random() * max);
   if (pos_neg) {
      d = Math.pow(-1, val);
   }
   return d * val;
}

/****************************************************************
* Select random color from approved list
****************************************************************/
const color_list = [
   "red",
   "orange",
   "yellow",
   "green",
   "blue",
   "purple",
   "magenta",
   "cyan",
   "teal"
];
function randomColor() {
   return color_list[rand(0,color_list.length)];
}
