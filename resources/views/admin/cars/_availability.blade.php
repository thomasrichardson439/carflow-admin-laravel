<script> window.carAvailabilitySlots = @json($availability); </script>

<div id="vue-availability">

    <input type="hidden" v-for="id in deletedAvailability" v-bind:value="id" name="deletedAvailability[]">

    <div class="row">
        <div class="col-6">
            <h3>Recurring availability</h3>
            <p class="text-muted">Set day and time of the week when car will be available on regular basis</p>

            <div class="row mB-20" v-if="recurring.length === 0">
                <div class="col-12">
                    <p class="text-muted"><i>No slots found. Add one by clicking button below</i></p>
                </div>
            </div>

            <div class="row mB-20" v-for="(item, index) in recurring">
                <input type="hidden" v-bind:value="item.id" v-bind:name="'recurring[' + item.id + '][id]'">
                <div class="col-4">
                    <select class="form-control non-disabling" v-model="item.day" v-bind:name="'recurring[' + item.id + '][day]'" :disabled="!editOn">
                        <option v-for="(day, key) in daysOfWeek" v-bind:value="key">@{{ day }}</option>
                    </select>
                </div>
                <div class="col-3">
                    <select class="form-control non-disabling" v-model="item.hour_from" v-bind:name="'recurring[' + item.id + '][hour_from]'" :disabled="!editOn">
                        <option v-for="(slot, key) in timeSlots" v-bind:value="key">@{{ slot }}</option>
                    </select>
                </div>
                <div class="col-3">
                    <select class="form-control non-disabling" v-model="item.hour_to" v-bind:name="'recurring[' + item.id + '][hour_to]'" :disabled="!editOn">
                        <option v-for="(slot, key) in timeSlotsTo" v-bind:value="key">@{{ slot }}</option>
                    </select>
                </div>
                <div class="col-1 pT-5" v-if="editOn">
                    <a href="#" v-on:click="removeRecurring(index)">Remove</a>
                </div>
            </div>

            <div class="row" v-if="editOn">
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

            <div class="row mB-20" v-if="onetime.length === 0">
                <div class="col-12">
                    <p class="text-muted"><i>No slots found. Add one by clicking button below</i></p>
                </div>
            </div>

            <div class="row mB-20" v-for="(item, index) in onetime">
                <input type="hidden" v-bind:value="item.id" v-bind:name="'onetime[' + item.id + '][id]'">
                <div class="col-4">
                    <input type="text" class="form-control non-disabling" v-model="item.date" v-bind:name="'onetime[' + item.id + '][date]'" :disabled="!editOn">
                </div>
                <div class="col-3">
                    <select class="form-control non-disabling" v-model="item.hour_from" v-bind:name="'onetime[' + item.id + '][hour_from]'" :disabled="!editOn">
                        <option v-for="(slot, key) in timeSlots" v-bind:value="key">@{{ slot }}</option>
                    </select>
                </div>
                <div class="col-3">
                    <select class="form-control non-disabling" v-model="item.hour_to" v-bind:name="'onetime[' + item.id + '][hour_to]'" :disabled="!editOn">
                        <option v-for="(slot, key) in timeSlotsTo" v-bind:value="key">@{{ slot }}</option>
                    </select>
                </div>
                <div class="col-1 pT-5" v-if="editOn">
                    <a href="#" v-on:click="removeOnetime(index)">Remove</a>
                </div>
            </div>

            <div class="row" v-if="editOn">
                <div class="col-12">
                    <button type="button" class="btn btn-danger" v-on:click="addOneTime()">
                        <i class="fa fa-plus"></i> Add one-time availability
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>