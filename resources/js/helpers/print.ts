import XLSX from 'xlsx-js-style'
import moment from 'moment'
import { NumberAddComma } from './converter';

export const PrintClientList = (contentData, name: string = '', start: string, end: string) => {
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
    const contentHeaderStyle = (border = [0, 0, 0, 0]) => {
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
            { v: "ID", ...contentHeaderStyle([1, 1, 1, 0]) },
            { v: "NAME", ...contentHeaderStyle([1, 0, 1, 0]) },
            { v: "USERNAME", ...contentHeaderStyle([1, 0, 1, 0])  },
            { v: "EMAIL", ...contentHeaderStyle([1, 0, 1, 0])  },
            { v: "PLAN", ...contentHeaderStyle([1, 0, 1, 0])  },
            { v: "PAY TYPE", ...contentHeaderStyle([1, 0, 1, 0])  },
            { v: "ADDRESS", ...contentHeaderStyle([1, 0, 1, 0])  },
            { v: "TOTAL", ...contentHeaderStyle([1, 0, 1, 0])  },
            { v: "AMOUNT TO PAY", ...contentHeaderStyle([1, 0, 1, 0])  },
            { v: "DUE DATE", ...contentHeaderStyle([1, 0, 1, 0])  },
            { v: "AGENT", ...contentHeaderStyle([1, 0, 1, 0])  },
            { v: "STAFF", ...contentHeaderStyle([1, 0, 1, 0])  },
            { v: "REGISTERED", ...contentHeaderStyle([1, 0, 1, 1])  },
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
            { v: "=123*123", ...contentHeaderStyle([1, 0, 0, 0]) },
            { v: "", ...contentHeaderStyle([1, 0, 0, 0]) },
            { v: "", ...contentHeaderStyle([1, 0, 0, 0])  },
            { v: "", ...contentHeaderStyle([1, 0, 0, 0])  },
            { v: "", ...contentHeaderStyle([1, 0, 0, 0])  },
            { v: "", ...contentHeaderStyle([1, 0, 0, 0])  },
            { v: "Total: ", ...contentHeaderStyle([1, 0, 0, 0])},
            {
                v: NumberAddComma(contentData.reduce((accumulator: number, total: Array<string>) => {
                    return accumulator + Number(total[7])
                }, 0))
                , ...contentHeaderStyle([1, 0, 0, 0])
            },
            {
                v: NumberAddComma(contentData.reduce((accumulator: number, total: Array<string>) => {
                    return accumulator + Number(total[8])
                }, 0))
                , ...contentHeaderStyle([1, 0, 0, 0])
            },
            { v: "", ...contentHeaderStyle([1, 0, 0, 0])  },
            { v: "", ...contentHeaderStyle([1, 0, 0, 0])  },
            { v: "", ...contentHeaderStyle([1, 0, 0, 0])  },
            { v: "", ...contentHeaderStyle([1, 0, 0, 0])  },
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

export const ClientPrintTransaction = (contentData, name: string = '') => {
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
    const contentHeaderStyle = (border = [0, 0, 0, 0]) => {
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
        [ { v: `Transaction Report`, ...headerStye, font: { name: "Calibri", sz: 12 } }, ],
        [],
        [
            { v: "Name: ", ...contentHeaderStyle() },
            { v: name, ...contentHeaderStyle()},
            {},
            { v: 'Date: ', ...contentHeaderStyle() },
            { v: moment().format('MMM DD, YYYY'), ...contentHeaderStyle() },
        ],

        // NOTE DATA HEADER
        [
            { v: "OR", ...contentHeaderStyle([1, 1, 1, 0]) },
            { v: "PLAN", ...contentHeaderStyle([1, 0, 1, 0]) },
            { v: "PAYMENT", ...contentHeaderStyle([1, 0, 1, 0]) },
            { v: "AMOUNT", ...contentHeaderStyle([1, 0, 1, 0])  },
            { v: "DATE", ...contentHeaderStyle([1, 0, 1, 1])  },
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
            { v: "", ...contentHeaderStyle([1, 0, 0, 0]) },
            { v: "", ...contentHeaderStyle([1, 0, 0, 0]) },
            { v: "Total: ", ...contentHeaderStyle([1, 0, 0, 0])},
            {
                v: NumberAddComma(contentData.reduce((accumulator: number, total: Array<string>) => {
                    return accumulator + Number(total[3])
                }, 0))
                , ...contentHeaderStyle([1, 0, 0, 0])
            },
            { v: "", ...contentHeaderStyle([1, 0, 0, 0]) },

        ],

    ]

    const ws = XLSX.utils.aoa_to_sheet(printContent);

    const merge = [
        {
            s: { r: 0, c: 0 },
            e: { r: 0, c: 4 }
        },
        {
            s: { r: 1, c: 0 },
            e: { r: 1, c: 4 }
        },
        // {
        //     s: { r: 3, c: 0 },
        //     e: { r: 4, c: 0 }
        // },
    ]
    ws['!merges'] = merge

    const colsWidth = [
        { width: 20 }, //OR
        { width: 20 }, //PLAN
        { width: 20 }, //PAYMENT
        { width: 20 }, //AMOUNT
        { width: 20 }, //DATE
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
