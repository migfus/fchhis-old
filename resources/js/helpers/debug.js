
const debug = true;

export const $DebugInfo = (name) => {
  if(debug)
    console.log(
      `%cDEBUG %cENABLED %c===========================>%c${name}%c<=========================🥴`,
      "color: red",
      'color: cyan',
      'color: green',
      'color: cyan',
      'color: green'
    )
}

export const $Err = (msg, input) => {
  if (debug) return console.log(`%c${msg}`, "color: red", input);
}

export const $Log = (msg, input) => {
  if (debug) return console.log(`%c${msg}`, "color: cyan", input);
}
