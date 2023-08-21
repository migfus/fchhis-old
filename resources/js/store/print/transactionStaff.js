import { ref } from 'vue'
import { defineStore } from 'pinia'
import pdfFonts from 'pdfmake/build/vfs_fonts.js';
import pdfMake from "pdfmake";
import { $DebugInfo, $Log } from '@/helpers/debug';
import DeviceDetector from "device-detector-js";
import { NumberAddComma } from '@/helpers/converter'
import moment from 'moment'
import { useAuthStore } from '@/store/auth/AuthStore'

export const useTransactionStaff = defineStore('transaction-staff', () => {
  $DebugInfo("Transaction Staff")

  const $auth = useAuthStore()
  const deviceDetector = new DeviceDetector();
  const device = deviceDetector.parse(navigator.userAgent)
  pdfMake.vfs = pdfFonts;

  function _sum(items, prop){
    return items.reduce( function(a, b){
        return Number(a) + Number(b[prop]);
    }, 0);
  };

  function Print(input) {
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
              text: `${input.header.start} - ${input.header.end}
              Payment Report`,
              fontSize: 15,
              alignment: 'center',
              margin: [0,10,0,0],
              decorationStyle: 'wavy'
            }
          ],
          {
            width: 50,
            // image: 'dti',
            text: '',
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
        margin: [0, 20, 0,0],
        table: {
          widths: [200, 200],
          body: [
            [
              { text: 'Summary', bold: true, colSpan: 2, alignment: 'center'},
              {},
            ],
            [
              { text: `Total: ${NumberAddComma(_sum(input.body, 'amount'))}`},
              { text: `Transactions: ${input.body.length}`},
            ]
          ]
        }
      },
      {
        margin: [0, 2, 0, 0],
        table: {
          widths: [100,60,60,60, 100],
          body: [
            [
              { text: 'Transactions', bold: true, colSpan: 4, alignment: 'center'},
              {},
              {},
              {},
              {},
            ],
            [
              { text: 'Name', bold: true },
              { text: 'Plan', bold: true },
              { text: 'Payment', bold: true },
              { text: 'Amount', bold: true },
              { text: 'Date', bold: true },
            ],
            // LOOP

            ...input.body.map(m => [`${m.name}`, `${m.plan}`, `${m.type}`, `${m.amount}`, `${m.date}`])

            ,
            [
              {},
              {},
              { text: 'Total: ', bold: true, alignment: 'right' },
              { text: NumberAddComma(_sum(input.body, 'amount')), bold: true },

              {},
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
        // logo: 'http://127.0.0.1:8000/images/logo.png',
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
            { text: `Client IP: ${$auth.ip}`, alignment: 'left' },
          ],
          { text: `${device.client.name}, ${device.os.name} ${device.os.version}`, alignment: 'right' },
        ],
      }
    })

    pdfMake.createPdf(template.value).open();
    $Log("Print", template.value)
  }

  return {
    Print,
  }
})
