import XLSX from 'xlsx-js-style';

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

export const PrintTest = (contentData) => {
    const wb = XLSX.utils.book_new();

    const headerStye = {
        font: {
            name: "Calibri", sz: 24
        },
        align: { horizontal: 'center' },
        innerWidth
    }
    const contentHeaderStyle = {
        s: {
            font: {
                name: 'Calibri', sz: 12, bold: true
            }
        },
        t: 's',
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
        [
            {
                v: "uture Care and Helping Hands Insurance Services",
                t: "s",
                s: headerStye
            },
        ],
        // ROW 2
        [
            {
                v: "uture Care and Helping Hands Insurance Services",
                t: "s",
                s: headerStye
            },
        ],
        [],
        [
            {
                v: "Name: ", ...headerStye
            },
            {

            }
        ],


        [
            { v: "ID", ...contentHeaderStyle },
            { v: "NAME", ...contentHeaderStyle },
            { v: "USERNAME", ...contentHeaderStyle },
            { v: "EMAIL", ...contentHeaderStyle },
            { v: "PLAN", ...contentHeaderStyle },
            { v: "PAY TYPE", ...contentHeaderStyle },
            { v: "ADDRESS", ...contentHeaderStyle },
            { v: "TOTAL", ...contentHeaderStyle },
            { v: "AMOUNT TO PAY", ...contentHeaderStyle },
            { v: "DUE DATE", ...contentHeaderStyle },
            { v: "AGENT", ...contentHeaderStyle },
            { v: "STAFF", ...contentHeaderStyle },
            { v: "REGISTERED", ...contentHeaderStyle },
        ],


        ...contentData.map(el => {
            let data = [];
            el.forEach(array1 => {
                data.push({ v: array1, ...contentStyle })
            });

            return data
        }),

    ]

    const ws = XLSX.utils.aoa_to_sheet(printContent);

    const merge = [
        {
            s: { r: 0, c: 0 },
            e: { r: 0, c: 4 }
        },
        // {
        //     s: { r: 3, c: 0 },
        //     e: { r: 4, c: 0 }
        // },
    ]
    ws['!merges'] = merge

    const colsWidth = [
        { width: 10 }, //ID
        { width: 30 }, //NAME
        { width: 20 }, //USERNAME
        { width: 25 }, //EMAIL
        { width: 20 }, //PLAN
        { width: 20 }, //PAY TYPE
        { width: 40 }, //ADDRESS
        { width: 10 }, //AMOUNT
        { width: 20 }, //DUEDATE
        { width: 30 }, //AGENT
        { width: 30 }, //STAFF
        { width: 20 }, //CREATED
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
