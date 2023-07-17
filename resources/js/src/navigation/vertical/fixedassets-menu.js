export default [
    {
        title: 'Fixed Assets',
        icon: 'BookIcon',
        children: [
            {
                title: 'Fixed Asset Master',
                route: null,
            },
            {
                title: 'Asset Location Master',
                toolTipText: 'Asset Location Master',
                route: null,
            },
            {
                title: 'Maintenance/Service Details',
                toolTipText: 'Maintenance/Service Details',
                route: null,
            },
            {
                title: 'Insurance Details',
                route: null,
            },
            {
                title: 'Fixed Asset Report',
                children: [
                    {
                        title: 'List Of Fixed Assets',
                        route: null,
                    },
                    {
                        title: 'Maintenance/Service Summary',
                        toolTipText: 'Maintenance/Service Summary',
                        route: null,
                    },
                    {
                        title: 'Insurance Summary',
                        toolTipText: 'Insurance Summary',
                        route: null,
                    }
                ]
            }
        ]

    },
]
