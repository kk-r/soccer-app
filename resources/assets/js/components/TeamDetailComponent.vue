<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div  class="panel panel-default" v-if="show404">
                    <div class="panel-heading">
                       Not Found
                    </div>

                    <div class="panel-body">
                       <p>Something Went wrong</p>
                    </div>
                </div>


                <div class="panel panel-default" v-else>
                    <div class="panel-heading">
                        <img width="200" :src="team.logo_url || 'http://via.placeholder.com/100?text=Dummy+Team+Pic'" alt="">
                        {{team.name}}
                    </div>

                    <div class="panel-body">
                        <h3>Players</h3>

                        <hr/>
                        <div class="card col-md-3" v-for="player in players">
                            <img class="card-img-top" :src="player.logo_url || 'http://via.placeholder.com/100?text=Dummy+Player+Pic'" alt="Card image cap">
                            <div class="card-block">
                                <p class="card-text"> {{player.first_name}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.loadTeam()
        },
        data() {
            return {
                'team': {},
                'players': {},
                show404:false
            }
        },
        methods: {
            loadTeam() {

                axios.get('/api/teams/' + window.team).then((response) => {
                    this.team = response.data.data;
                }).catch((err) => {
                    let response = err.response;

                    if (response.status === 404) {
                        console.log(response.status);
                        this.show404 = true;
                    }
                });

                axios.get('/api/teams/' + window.team + '/players').then((response) => {
                    this.players = response.data.data;
                }).catch((err) => {
                    let response = err.response;
                    if (response.status === 404) {
                        this.show404 = true;
                    }
                });
            }
        }
    }
</script>
