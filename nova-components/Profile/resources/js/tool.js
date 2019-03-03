Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'profile',
            path: '/profile',
            component: require('./components/Tool'),
        },
    ])
})
