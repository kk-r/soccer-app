<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Teams</div>

                    <div class="panel-body">
                        <div class="card col-md-3" style="padding: 10px;" v-for="team in teams">
                            <img class="card-img-top" :src="team.logo_url || 'http://via.placeholder.com/100?text=Dummy+Team+Pic'" alt="Card image cap">
                            <div class="card-block">
                                <h4 class="card-title">{{team.name}}</h4>
                                <p></p>
                                <a :href="'team/'+team.id+'/players'" class="btn btn-primary">View player(s)</a>
                            </div>
                        </div>
                        <p v-if="teams.length == 0"> No information available.</p>
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
                'teams': []
            }
        },
        methods: {
            loadTeam() {
                axios.get('/api/teams').then((response) => {
                    this.teams = response.data.data;
                }).catch((response) => {
                    console.error(response);
                })
            }
        }
    }
</script>
