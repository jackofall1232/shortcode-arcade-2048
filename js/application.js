// Wait till the browser is ready to render the game (avoids glitches)
window.requestAnimationFrame(function () {
  var containers = document.querySelectorAll(".sacga-2048");

  containers.forEach(function (container) {
    new GameManager(4, KeyboardInputManager, HTMLActuator, LocalStorageManager, container);
  });
});
