<template>
    <div class="w-100">
        <div
            class="position-absolute d-flex w-100 h-100 bg-light justify-content-center align-items-center top-0 opacity-75"
            v-if="isLoading"
        >
            <div class="spinner-border text-primary" role="status"></div>
        </div>
        <div class="container-fluid mt-5" v-if="view === 0">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h3 class="text-left mb-4">Tournament table</h3>
                    <table class="table">
                        <thead>
                        <tr class="table-dark">
                            <th>Team Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="team in table" :key="team.id">
                            <td>{{ team.name }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <button
                        type="button"
                        class="btn btn-primary text-capitalize"
                        @click="generateFixtures"
                    >
                        Generate fixtures
                    </button>
                </div>
            </div>
        </div>
        <div class="container-fluid mt-5" v-else-if="view === 1">
            <div class="row justify-content-between border-bottom mb-3">
                <h3 class="text-center mb-4">Simulation</h3>
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                        <tr class="table-dark">
                            <th>Team Name</th>
                            <th>P</th>
                            <th>W</th>
                            <th>D</th>
                            <th>L</th>
                            <th>GD</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="team in table" :key="team.id">
                            <td>{{ team.name }}</td>
                            <td>{{ team.points }}</td>
                            <td>{{ team.won }}</td>
                            <td>{{ team.draw }}</td>
                            <td>{{ team.lost }}</td>
                            <td>{{ team.gd }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-3">
                    <table class="table" v-if="weekMatches.weekNumber !== undefined">
                        <thead>
                        <tr class="table-dark">
                            <th colspan="3">Week {{ weekMatches.weekNumber }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(match, index) in weekMatches.matches" :key="index">
                            <td>{{ match.homeTeamName }}</td>
                            <td class="text-center">{{ match.homeGoal }} - {{ match.awayGoal }}</td>
                            <td>{{ match.awayTeamName }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <button
                        type="button"
                        class="btn btn-link text-capitalize"
                        @click="viewFixtures"
                    >
                        View fixtures
                    </button>
                </div>
                <div class="col-md-3">
                    <table class="table">
                        <thead>
                        <tr class="table-dark">
                            <th>Champoinship predictions</th>
                            <th>%</th>
                        </tr>
                        </thead>
                        <tbody v-if="predictions.length > 0">
                        <tr v-for="(team, index) in predictions">
                            <td>{{ team.teamName }}</td>
                            <td class="float-end">{{ team.percentage }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-around">
                <button
                    type="button"
                    class="btn btn-primary text-capitalize"
                    @click="playAll"
                >
                    Play all weeks
                </button>
                <button
                    type="button"
                    class="btn btn-primary text-capitalize"
                    @click="playNextWeek"
                >
                    Play next week
                </button>
                <button
                    type="button"
                    class="btn btn-danger text-capitalize"
                    @click="reset"
                >
                    Reset data
                </button>
            </div>
        </div>
        <div class="container-fluid mt-5" v-else-if="view === 2">
            <div class="row mb-3 px-3">
                <h3 class="text-center mb-4">Generated Fixtures</h3>
                <div class="col-md-3" v-for="fixture in fixtures" :key="fixture.weekNumber">
                    <table class="table">
                        <thead>
                        <tr class="table-dark">
                            <th colspan="3">Week {{ fixture.weekNumber }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="single in fixture.matches">
                            <td>{{ single.homeTeamName }}</td>
                            <td class="text-center">{{ single.homeGoal }} - {{ single.awayGoal }}</td>
                            <td>{{ single.awayTeamName }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <button type="button" class="btn btn-primary ml-3" @click="startSimulation">Start Simulation
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            view: 0,
            table: [],
            fixtures: [],
            predictions: [],
            weekMatches: [],
            isLoading: true,
        };
    },
    async mounted() {
        setTimeout(() => {
            console.clear()
        }, 1000)
        await this.standingAndPrediction()
    },
    methods: {
        async playAll() {
            try {
                const response = await axios.post('/api/play-all');
                if (response.status === 200) {
                    await this.standingAndPrediction()
                    this.view = 1;
                } else {
                    this.alertError(response.data.data.message)
                }
            } catch (e) {
                console.log(e)
            }
        },
        async playNextWeek() {
            try {
                const response = await axios.post('/api/play-next');
                if (response.status === 200) {
                    await this.standingAndPrediction()
                    this.view = 1;
                } else {
                    this.alertError(response.data.data.message)
                }
            } catch (e) {
                console.log(e)
            }
        },
        async reset() {
            const response = await axios.post('/api/reset');
            if (response.status === 200) {
                await this.standingAndPrediction()
                this.view = 0;
            } else {
                this.alertError(response.data.data.message)
            }
        },
        async getStanding() {
            const response = await axios.get('/api/standings');

            if (response.status === 200) {
                this.table = response.data.data.table;
                if (response.data.data.nextWeekFixtures === null) {
                    this.weekMatches = [];
                    this.view = 0;
                } else {
                    this.weekMatches = response.data.data.nextWeekFixtures;
                    this.view = 1;
                }
            } else {
                this.alertError(response.data.data.message)
            }
        },
        async generateFixtures() {
            try {
                const response = await axios.post('/api/generate-fixtures');
                if (response.status === 200) {
                    this.fixtures = response.data.data;
                    this.view = 2
                } else {
                    this.alertError(response.data.data.message)
                }
            } catch (e) {
                console.log(e)
            }
        },
        async getFixtures() {
            const response = await axios.get('/api/fixtures');
            if (response.status === 200) {
                this.fixtures = response.data.data;
                this.view = 2
            } else {
                this.alertError(response.data.data.message)
            }
        },
        async viewFixtures() {
            await this.getFixtures();
            this.view = 2;
        },
        async standingAndPrediction() {
            this.isLoading = true;
            await this.getStanding();
            await this.getPredictions();
            this.isLoading = false;
        },
        async startSimulation() {
            await this.standingAndPrediction()
            this.view = 1
        },
        async getPredictions() {
            const response = await axios.get('/api/predictions');
            if (response.status === 200) {
                this.predictions = response.data.data;
            } else {
                this.predictions = []
                this.alertError(response.data.data.message)
            }
        },
        alertError(message) {
            alert(message ? message : 'Something wrong happened')
        },
    }
}
</script>

<style scoped>
th, td {
    padding: 15px 10px !important;
}

tbody tr:last-child > td {
    border-bottom: 0;
}
</style>
