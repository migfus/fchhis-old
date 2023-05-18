import { reactive, ref } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { $DebugInfo, $Log, $Err} from '@/helpers/debug'

export const useTestStore = defineStore('test', () => {
  $DebugInfo('TestSTore')
  const CancelToken = axios.CancelToken;
  let cancel;

  async function GetAPI() {
    try {
      let res = await axios.get('https://catfact.ninja/fact', {
        cancelToken: new CancelToken(function executor(c) { cancel = c; })
      });
      $Log('TestStore GetAPI', {res})
    }
    catch(e) {
      $Err('Test STore GetAPI', {e})
    }
  }

  function CloseAPI() {
    cancel();
  }

  return {
    GetAPI,
    CloseAPI
  }
})
