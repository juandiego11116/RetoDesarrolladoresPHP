    const app = new Vue({
    el: '#app',
    created() {

        this.getUser();

    },
    data: {
        users: [],
        search: '',
        setTimeoutSearch: ''
    },
    methods: {

        getUser() {

            axios.get('/users.getUsers', {
                params: {
                    search: this.search
                }
            })
                .then( res => {
                    this.users = res.data;
                })
                .catch( error => {
                    console.log( error.response )
                });


        },

        searchUser() {

            clearTimeout( this.setTimeoutSearch )
            this.setTimeoutSearch = setTimeout(this.getUser, 360)

        }

    }
});

