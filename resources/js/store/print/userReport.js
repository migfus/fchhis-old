import { ref, reactive, computed} from 'vue'
import { defineStore } from 'pinia'
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
import { $DebugInfo, $Log, $Err} from '@/helpers/debug';
import axios from 'axios'
import DeviceDetector from "device-detector-js";
import { NumberAddComma } from '@/helpers/converter'
import moment from 'moment'

export const userReportStore = defineStore('user-report', () => {
  $DebugInfo("UserReport")

  const deviceDetector = new DeviceDetector();
  const device = deviceDetector.parse(navigator.userAgent)
  pdfMake.vfs = pdfFonts;

  const ipAddress = ref('')

  function _sum(items, prop){
    return items.reduce( function(a, b){
        return Number(a) + Number(b[prop]);
    }, 0);
  };

  function Print(input) {
    getIP()

    const pdfContent = ref([
      {
        columns: [
          {
            width: 80,
            image: 'logo',
            margin: [-10, 0,0,0]
          },
          [
            {
              text: 'Future Care and Helping Hands',
              fontSize: 15,
              alignment: 'center',
              bold: true,
            },
            {
              text: 'Insurance Services',
              fontSize: 15,
              alignment: 'center',
              bold: true,
            },
            {
              text: '2nd Floor, Facoma Bldg., P-12 Poblacion, Valencia City, Bukidnon',
              fontSize: 12,
              alignment: 'center',
            },
            {
              text: `${input.header.title} \n Users Report`,
              fontSize: 15,
              alignment: 'center',
              margin: [0,10,0,0],
              decorationStyle: 'wavy'
            }
          ],
          {
            width: 50,
            image: 'dti',
          }
        ],
      },
      {
        margin: [0, 20, 0,0],
        table: {
          widths: [500],
          body: [
            [`Date & Time: ${moment().format('MMM D, YYYY HH:mm A')}`],
            [`Name: ${input.header.name}`],
          ]
        }
      },
      {
        margin: [0, 2, 0, 0],
        table: {
          widths: [100, 110, 140, 120],
          body: [
            [
              { text: 'Name', bold: true },
            { text: 'Plan', bold: true },
              { text: 'Payment Type', bold: true },
              { text: 'Amount', bold: true },
            ],
            // LOOP

            ...input.body.map(m => [`${m.name}`, `${m.plan}`, `${m.type}`, NumberAddComma(m.amount)])

            ,
            [
              {},
              {},
              { text: 'Total: ', bold: true, alignment: 'right' },
              { text: NumberAddComma(_sum(input.body, 'amount')), bold: true },
            ]
          ]
        }
      },
    ])

    const template = ref({
      pageMargins: [ 40, 20, 40, 60 ],
      pageSize: 'A4',
      images: {
        logo: 'https://fchhis.migfus20.com/images/logo.png',
        dti: 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f2/DTI_PH_new_logo.svg/1200px-DTI_PH_new_logo.svg.png'
      },
      header: [],
      styles: {
        header: {
          fontSize: 18,
          bold:true
        },
      },
      // NOTE CONTENTS
      content: pdfContent,
      footer: {
        margin: [20, 0, 20,0],
        columns: [
          [
            { text: window.location.href, alignment: 'left' },
            { text: `Client IP: ${ipAddress.value}`, alignment: 'left' },
          ],
          { text: `${device.client.name}, ${device.os.name} ${device.os.version}`, alignment: 'right' },
        ],
      }
    })

    pdfMake.createPdf(template.value).open();
    $Log("Print", template.value)
  }

  async function getIP() {
    try {
      const { ip } = await axios.get('https://api.ipify.org/?format=json')
      ipAddress.value = ip
    }
    catch(e) {

    }
  }

  return {
    Print,
  }
})
