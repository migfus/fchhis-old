import { ref } from 'vue'
import { defineStore } from 'pinia'
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
import { $DebugInfo, $Log } from '@/helpers/debug';
import DeviceDetector from "device-detector-js";
import { NumberAddComma } from '@/helpers/converter'
import { useAuthStore } from '@/store/auth/auth'

export const userDetailStore = defineStore('user-details', () => {
  $DebugInfo("UserReport")

  const $auth = useAuthStore();
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
              text: `${input.header.title}`,
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
          widths: [250, 250],
          body: [
            [
              `Name: ${input.header.name}`,
              `Registered on: ${input.header.created_at}`,
            ],
            [
              `BirthDay: ${input.header.bday}`,
              `Birth Place: ${input.header.bplace}`,
            ],
            [
              `Sex: ${input.header.sex}`,
              `Address: ${input.header.address}`,
            ],
            [
              `Email: ${input.header.email}`,
              `Contact Number: ${input.header.mobile}`,
            ],
          ]
        }
      },
      {
        margin: [0, 2, 0, 0],
        fontSize: 12,
        table: {
          widths: [150, 100, 100, 100],
          body: [
            [
              {
                text: 'TRANSACTIONS', colSpan: 4, bold: true, alignment: 'center'
              }, {}, {}, {}
            ],
            [
              { text: 'Name', bold: true },
              { text: 'Payment Type', bold: true },
              { text: 'Amount', bold: true },
              { text: 'Date', bold: true },
              // { text: 'Date', bold: true },
            ],
            // LOOP

            ...input.body.map(m => [m.name, m.type, m.amount, m.created])

            ,
            [
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

    // pdfMake.createPdf({}).open();
    pdfMake.createPdf(template.value).open();
    $Log("Print", template.value)
  }

  return {
    Print,
  }
})
