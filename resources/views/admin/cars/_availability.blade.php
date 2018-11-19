<div id="vue-availability">
    <div class="row">
        <div class="col-6">
            <h3>Recurring availability</h3>
            <p class="text-muted">Set day and time of the week when car will be available on regular basis</p>

            <div class="row mB-20" v-for="(item, index) in recurring">
                <div class="col-4">
                    <input type="text" class="form-control" v-model="item.day" v-bind:name="'recurring[' + item.id + '][day]'">
                </div>
                <div class="col-3">
                    <input type="text" class="form-control" v-model="item.hourFrom" v-bind:name="'recurring[' + item.id + '][hour_from]'">
                </div>
                <div class="col-3">
                    <input type="text" class="form-control" v-model="item.hourTo" v-bind:name="'recurring[' + item.id + '][hour_to]'">
                </div>
                <div class="col-1 edit-on">
                    <a href="#" v-on:click="removeRecurring(index)">Remove</a>
                </div>
            </div>

            <div class="row edit-on">
                <div class="col-12">
                    <button type="button" class="btn btn-danger" v-on:click="addRecurring()">
                        <i class="fa fa-plus"></i> Add recurring availability
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mT-30">
        <div class="col-6">
            <h3>One-time availability</h3>
            <p class="text-muted">Set day and time when car will be available on one-time basis</p>

            <div class="row mB-20" v-for="(item, index) in onetime">
                <div class="col-4">
                    <input type="text" class="form-control" v-model="item.date" v-bind:name="'onetime[' + item.id + '][date]'">
                </div>
                <div class="col-3">
                    <input type="text" class="form-control" v-model="item.hourFrom" v-bind:name="'onetime[' + item.id + '][hour_from]'">
                </div>
                <div class="col-3">
                    <input type="text" class="form-control" v-model="item.hourTo" v-bind:name="'onetime[' + item.id + '][hour_to]'">
                </div>
                <div class="col-1 edit-on">
                    <a href="#" v-on:click="removeOnetime(index)">Remove</a>
                </div>
            </div>

            <div class="row edit-on">
                <div class="col-12">
                    <button type="button" class="btn btn-danger" v-on:click="addOneTime()">
                        <i class="fa fa-plus"></i> Add one-time availability
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>