import XLSX from 'xlsx-js-style'
import moment from 'moment'

// const contentData = [
//     [
//         '1',
//         'name',
//         'username',
//         'email',
//         'plan',
//         'payType',
//         'address',
//         'total',
//         'amount_topay',
//         'agent',
//         'staff',
//         'created_at'
//     ],
//     [
//         '1',
//         'name',
//         'username',
//         'email',
//         'plan',
//         'payType',
//         'address',
//         'total',
//         'amount_topay',
//         'agent',
//         'staff',
//         'created_at'
//     ],
//     [
//         '1',
//         'name',
//         'username',
//         'email',
//         'plan',
//         'payType',
//         'address',
//         'total',
//         'amount_topay',
//         'agent',
//         'staff',
//         'created_at'
//     ],
// ]

export const PrintTest = (contentData, name: string = '', start: string, end: string) => {
    const wb = XLSX.utils.book_new();

    const headerStye = {
        s: {
            font: { name: "Calibri", sz: 24 },
            align: { horizontal: 'center', vertical: 'center' },
            alignment: { horizontal: 'center', vertical: 'center'  },
            innerWidth
        },
        t: 's'

    }
    const contentHeaderStyle = (border = [false, false, false, false]) => {
        return {
            s: {
                font: {
                    name: 'Calibri', sz: 12, bold: true
                },
                border: {
                    top: { color: { rgb: border[0] ? '000' : 'FFFFFF'}},
                    left: { color: { rgb: border[1] ? '000' : 'FFFFFF'}},
                    bottom: { color: { rgb: border[2] ? '000' : 'FFFFFF'}},
                    right: { color: { rgb: border[3] ? '000' : 'FFFFFF'}},
                }
            },
            t: 's',
        }

    }
    const contentStyle = {
        s: {
            font: {
                name: 'Calibri', sz: 12,
            }
        },
        t: 's',
    }

    const printContent  =  [
        // ROW1
        [ { v: "Future Care and Helping Hands Insurance Services", ...headerStye }, ],
        // ROW 2
        [ { v: `Clients Report from ${moment(start).format('MMM DD, YYYY')} - ${moment(end).format('MMM DD, YYYY')}`, ...headerStye, font: { name: "Calibri", sz: 12 } }, ],
        [],
        [
            { v: "Staff Name: ", ...contentHeaderStyle() },
            { v: name, ...contentHeaderStyle()},
            { v: name, ...contentHeaderStyle()},
            {},
            {},
            {},
            {},
            {},
            {},
            {},
            {},
            { v: 'Date: ', ...contentHeaderStyle() },
            { v: moment().format('MMM DD, YYYY'), ...contentHeaderStyle() },
        ],

        // NOTE DATA HEADER
        [
            { v: "ID", ...contentHeaderStyle([true, true, true, false]) },
            { v: "NAME", ...contentHeaderStyle([true, false, true, false]) },
            { v: "USERNAME", ...contentHeaderStyle([true, false, true, false])  },
            { v: "EMAIL", ...contentHeaderStyle([true, false, true, false])  },
            { v: "PLAN", ...contentHeaderStyle([true, false, true, false])  },
            { v: "PAY TYPE", ...contentHeaderStyle([true, false, true, false])  },
            { v: "ADDRESS", ...contentHeaderStyle([true, false, true, false])  },
            { v: "TOTAL", ...contentHeaderStyle([true, false, true, false])  },
            { v: "AMOUNT TO PAY", ...contentHeaderStyle([true, false, true, false])  },
            { v: "DUE DATE", ...contentHeaderStyle([true, false, true, false])  },
            { v: "AGENT", ...contentHeaderStyle([true, false, true, false])  },
            { v: "STAFF", ...contentHeaderStyle([true, false, true, false])  },
            { v: "REGISTERED", ...contentHeaderStyle([true, false, true, true])  },
        ],

        // NOTE DATA
        ...contentData.map(el => {
            let data = [];
            el.forEach(array1 => {
                data.push({ v: array1, ...contentStyle })
            });

            return data
        }),

        // NOTE FOOTER
        [
            { v: "", ...contentHeaderStyle([true, false, false, false]) },
            { v: "", ...contentHeaderStyle([true, false, false, false]) },
            { v: "", ...contentHeaderStyle([true, false, false, false])  },
            { v: "", ...contentHeaderStyle([true, false, false, false])  },
            { v: "", ...contentHeaderStyle([true, false, false, false])  },
            { v: "", ...contentHeaderStyle([true, false, false, false])  },
            { v: "Total: ", ...contentHeaderStyle([true, false, false, false])},
            {
                v: contentData.reduce((accumulator, total) => {
                    console.log(total[7])
                    return accumulator + Number(total[7])
                }, 0)
                , ...contentHeaderStyle([true, false, false, false])
            },
            {
                v: contentData.reduce((accumulator, total) => {
                    console.log(total[8])
                    return accumulator + Number(total[8])
                }, 0)
                , ...contentHeaderStyle([true, false, false, false])
            },
            { v: "", ...contentHeaderStyle([true, false, false, false])  },
            { v: "", ...contentHeaderStyle([true, false, false, false])  },
            { v: "", ...contentHeaderStyle([true, false, false, false])  },
            { v: "", ...contentHeaderStyle([true, false, false, false])  },
        ],

    ]

    const ws = XLSX.utils.aoa_to_sheet(printContent);

    const merge = [
        {
            s: { r: 0, c: 0 },
            e: { r: 0, c: 12 }
        },
        {
            s: { r: 1, c: 0 },
            e: { r: 1, c: 12 }
        },
        // {
        //     s: { r: 3, c: 0 },
        //     e: { r: 4, c: 0 }
        // },
    ]
    ws['!merges'] = merge

    const colsWidth = [
        { width: 20 }, //ID
        { width: 30 }, //NAME
        { width: 20 }, //USERNAME
        { width: 30 }, //EMAIL
        { width: 15 }, //PLAN
        { width: 15 }, //PAY TYPE
        { width: 40 }, //ADDRESS
        { width: 10 }, //AMOUNT
        { width: 10 }, //DUEDATE
        { width: 30 }, //AGENT
        { width: 30 }, //STAFF
        { width: 30 }, //CREATED
        { width: 30 }, //CREATED
    ];
    ws['!cols'] = colsWidth;

    // ws["A1"].s = {
    //     font: {
    //         name: "Calibri",
    //         sz: 24,
    //         bold: true,
    //         color: { rgb: "FFFFAA00" },
    //     },
    // };

    XLSX.utils.book_append_sheet(wb, ws, "readme demo");
    XLSX.writeFile(wb, "xlsx-js-style-demo.xlsx");
}
