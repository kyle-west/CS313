_can = new Screen(window.innerWidth,window.innerHeight);
_can.setup();
_can.centerOrigin();
_can.background('#3681f9');
_scene = new RenderEngine(_can);
_scene.framerate = 33;
obj0 = new Renderable(new Location(0,0,2,-3), function () {
   _scene.context.fillStyle = "red";
   _scene.context.fillRect(
      this.location.getX(),this.location.getY(),
      15,15);
   }
);

obj1 = new Renderable(new Location(100,-15,-1,5), function () {
   _scene.context.fillStyle = "orange";
   _scene.context.fillRect(
      this.location.getX(),this.location.getY(),
      15,15);
   }
);
obj2 = new Renderable(new Location(-100,-15,5,0), function () {
   _scene.context.fillStyle = "yellow";
   _scene.context.fillRect(
      this.location.getX(),this.location.getY(),
      15,15);
   }
);
obj3 = new Renderable(new Location(0,0,-3,2), function () {
   _scene.context.fillStyle = "green";
   _scene.context.fillRect(
      this.location.getX(),this.location.getY(),
      15,15);
   }
);
obj4 = new Renderable(new Location(-25,25,-1,-3), function () {
   _scene.context.fillStyle = "blue";
   _scene.context.fillRect(
      this.location.getX(),this.location.getY(),
      15,15);
   }
);
obj5 = new Renderable(new Location(-30,2,-5,-2), function () {
   _scene.context.fillStyle = "purple";
   _scene.context.fillRect(
      this.location.getX(),this.location.getY(),
      15,15);
   }
);
obj6 = new Renderable(new Location(10,13,2,-4), function () {
   _scene.context.fillStyle = "magenta";
   _scene.context.fillRect(
      this.location.getX(),this.location.getY(),
      15,15);
   }
);
obj7 = new Renderable(new Location(7,-22,-2,1), function () {
   _scene.context.fillStyle = "cyan";
   _scene.context.fillRect(
      this.location.getX(),this.location.getY(),
      15,15);
   }
);
obj8 = new Renderable(new Location(55,10,-3,-4), function () {
   _scene.context.fillStyle = "teal";
   _scene.context.fillRect(
      this.location.getX(),this.location.getY(),
      15,15);
   }
);

_scene.bufferAdd(obj0);
_scene.bufferAdd(obj1);
_scene.bufferAdd(obj2);
_scene.bufferAdd(obj3);
_scene.bufferAdd(obj4);
_scene.bufferAdd(obj5);
_scene.bufferAdd(obj6);
_scene.bufferAdd(obj7);
_scene.bufferAdd(obj8);

_scene.animate();
