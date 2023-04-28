
const debug = true;

let called = false;
let name = '';
export const $DebugInfo = (_name) => {
  name = _name;
  called = false;
}

export const $Err = (msg, input) => {
  if (debug) {
    message();
    return console.log(`%c${msg}`, "color: red", input);
  }
}

export const $Log = (msg, input) => {
  if (debug) {
    message();
    return console.log(`%c${msg}`, "color: cyan", input);
  }
}

function message() {
  if(!called) {
    called = true;
    console.log(
      `%cDEBUG %cENABLED %c===========================>%c${name}%c<=========================🥴`,
      "color: red",
      'color: cyan',
      'color: green',
      'color: cyan',
      'color: green'
    )
  }
}
