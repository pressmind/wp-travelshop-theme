<?php
    $randomHash = bin2hex(random_bytes(5));
?>
<!-- Embed Vue3 -->
<script src="/wp-content/themes/travelshop/assets/js/vue-3.2.47.js"></script>
<!--<script src="/wp-content/themes/travelshop/assets/js/jquery-3.5.1.min.js"></script>-->
<script src="/wp-content/themes/travelshop/assets/js/jquery.timepicker.min.js"></script>
<link rel="stylesheet" href="/wp-content/themes/travelshop/assets/css/jquery.timepicker.min.css" />
<script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.1/dist/js/datepicker-full.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.1/dist/css/datepicker.min.css" rel="stylesheet">
<script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo TS_GOOGLEMAPS_API;?>&callback=initGoogle"></script>
<script>
    let $ = jQuery;
    function initGoogle() {
        return;
    }
</script>

<div id="ts-transportation-request-<?php echo $randomHash; ?>">
    <div v-if="!this.APIKeyProvided" class="ts-trr-error">
        Error: API Key not provided
    </div>
    <div v-if="this.APIKeyProvided" class="ts-transportation-request">
        <div class="ts-transportation-request-steps">
            <div v-for="(step, index) in steps" @click="step.ready && this.validData ? this.currentStep = (index + 1) : null" style="cursor: pointer;" :class="{ 'disabled': !step.ready, 'done': step.ready && this.currentStep != index + 1 }" class="ts-trr-step">
                <div> {{ index + 1 }} </div>
                <div> {{ step.name }} </div>
            </div>
        </div>
        <div style="font-size: 1.3rem; color: #15803d; padding: 2rem 2rem 1rem 2rem;" v-if="this.submitStatus.sent">
            {{ this.submitStatus.message }}
        </div>
        <div v-if="currentStep == 1 && !this.submitStatus.sent" class="ts-transportation-request-step">
            <div class="ts-trr-heading">
                1. Busanfrage
            </div>
            <hr />
            <div class="ts-trr-route-options">
                <div class="ts-trr-input flex1">
                    <label><span>Startpunkt*</span>
                        <input v-model="this.inputFrom" @keydown="startedPlaceTyping('inputFromLoading', 'inputFromObj')" @keyup="endedPlaceTyping('inputFrom')" type="text" placeholder="Ort / PLZ / Straße" />
                        <svg v-if="this.inputFromObj" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#047857" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="icon valid icon-tabler icon-tabler-circle-check-filled" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z"/><path fill="#047857" stroke="none" d="M17 3.34a10 10 0 1 1-14.995 8.984L2 12l.005-.324A10 10 0 0 1 17 3.34zm-1.293 5.953a1 1 0 0 0-1.32-.083l-.094.083L11 12.585l-1.293-1.292-.094-.083a1 1 0 0 0-1.403 1.403l.083.094 2 2 .094.083a1 1 0 0 0 1.226 0l.094-.083 4-4 .083-.094a1 1 0 0 0-.083-1.32z"/></svg>
                        <svg v-if="!this.inputFromObj && this.validationError" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="icon icon-tabler icon-tabler-square-rounded-x-filled" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z"/><path fill="red" stroke="none" d="m12 2 .324.001.318.004.616.017.299.013.579.034.553.046c4.785.464 6.732 2.411 7.196 7.196l.046.553.034.579c.005.098.01.198.013.299l.017.616L22 12l-.005.642-.017.616-.013.299-.034.579-.046.553c-.464 4.785-2.411 6.732-7.196 7.196l-.553.046-.579.034c-.098.005-.198.01-.299.013l-.616.017L12 22l-.642-.005-.616-.017-.299-.013-.579-.034-.553-.046c-4.785-.464-6.732-2.411-7.196-7.196l-.046-.553-.034-.579a28.058 28.058 0 0 1-.013-.299l-.017-.616C2.002 12.432 2 12.218 2 12l.001-.324.004-.318.017-.616.013-.299.034-.579.046-.553c.464-4.785 2.411-6.732 7.196-7.196l.553-.046.579-.034c.098-.005.198-.01.299-.013l.616-.017c.21-.003.424-.005.642-.005zm-1.489 7.14a1 1 0 0 0-1.218 1.567L10.585 12l-1.292 1.293-.083.094a1 1 0 0 0 1.497 1.32L12 13.415l1.293 1.292.094.083a1 1 0 0 0 1.32-1.497L13.415 12l1.292-1.293.083-.094a1 1 0 0 0-1.497-1.32L12 10.585l-1.293-1.292-.094-.083z"/></svg>
                        <img v-if="inputFromLoading" class="loader" src="/wp-content/themes/travelshop/assets/img/loading-dots-gray.svg" alt="loading" />
                    </label>
                    <div class="ts-trr-predictions">
                        <div v-if="predirectionsStatus == 'ZERO_RESULTS'">
                            <strong>Keine Ergebnisse</strong>
                        </div>
                        <div v-for="pred in predictions" @mouseDown="this.inputFrom = pred.structured_formatting.main_text + ', ' + pred.structured_formatting.secondary_text; this.inputFromObj = pred;">
                            <strong>{{ pred.structured_formatting.main_text }}</strong><br />
                            <small>{{ pred.structured_formatting.secondary_text }}</small>
                        </div>
                    </div>
                </div>
                <div class="ts-trr-input flex1">
                    <label><span>Zielpunkt*</span>
                        <input v-model="this.inputTo" @keydown="startedPlaceTyping('inputToLoading', 'inputToObj')" @keyup="endedPlaceTyping('inputTo')" type="text" placeholder="Ort / PLZ / Straße" />
                        <svg v-if="this.inputToObj" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#047857" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="icon valid icon-tabler icon-tabler-circle-check-filled" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z"/><path fill="#047857" stroke="none" d="M17 3.34a10 10 0 1 1-14.995 8.984L2 12l.005-.324A10 10 0 0 1 17 3.34zm-1.293 5.953a1 1 0 0 0-1.32-.083l-.094.083L11 12.585l-1.293-1.292-.094-.083a1 1 0 0 0-1.403 1.403l.083.094 2 2 .094.083a1 1 0 0 0 1.226 0l.094-.083 4-4 .083-.094a1 1 0 0 0-.083-1.32z"/></svg>
                        <svg v-if="!this.inputToObj && this.validationError" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="icon icon-tabler icon-tabler-square-rounded-x-filled" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z"/><path fill="red" stroke="none" d="m12 2 .324.001.318.004.616.017.299.013.579.034.553.046c4.785.464 6.732 2.411 7.196 7.196l.046.553.034.579c.005.098.01.198.013.299l.017.616L22 12l-.005.642-.017.616-.013.299-.034.579-.046.553c-.464 4.785-2.411 6.732-7.196 7.196l-.553.046-.579.034c-.098.005-.198.01-.299.013l-.616.017L12 22l-.642-.005-.616-.017-.299-.013-.579-.034-.553-.046c-4.785-.464-6.732-2.411-7.196-7.196l-.046-.553-.034-.579a28.058 28.058 0 0 1-.013-.299l-.017-.616C2.002 12.432 2 12.218 2 12l.001-.324.004-.318.017-.616.013-.299.034-.579.046-.553c.464-4.785 2.411-6.732 7.196-7.196l.553-.046.579-.034c.098-.005.198-.01.299-.013l.616-.017c.21-.003.424-.005.642-.005zm-1.489 7.14a1 1 0 0 0-1.218 1.567L10.585 12l-1.292 1.293-.083.094a1 1 0 0 0 1.497 1.32L12 13.415l1.293 1.292.094.083a1 1 0 0 0 1.32-1.497L13.415 12l1.292-1.293.083-.094a1 1 0 0 0-1.497-1.32L12 10.585l-1.293-1.292-.094-.083z"/></svg>
                        <img v-if="inputToLoading" class="loader" src="/wp-content/themes/travelshop/assets/img/loading-dots-gray.svg" alt="loading" />
                    </label>
                    <div class="ts-trr-predictions">
                        <div v-if="predirectionsStatus == 'ZERO_RESULTS'">
                            <strong>Keine Ergebnisse</strong>
                        </div>
                        <div v-for="pred in predictions" @mouseDown="this.inputTo = pred.structured_formatting.main_text + ', ' + pred.structured_formatting.secondary_text; this.inputToObj = pred;">
                            <strong>{{ pred.structured_formatting.main_text }}</strong><br />
                            <small>{{ pred.structured_formatting.secondary_text }}</small>
                        </div>
                    </div>
                </div>
                <div class="ts-trr-input">
                    <label><span>Personen*</span>
                        <input v-model="this.countPersons" type="number" placeholder="z.B. 30" />
                        <svg v-if="this.countPersons == '' && this.validationError" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="icon icon-tabler icon-tabler-square-rounded-x-filled" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z"/><path fill="red" stroke="none" d="m12 2 .324.001.318.004.616.017.299.013.579.034.553.046c4.785.464 6.732 2.411 7.196 7.196l.046.553.034.579c.005.098.01.198.013.299l.017.616L22 12l-.005.642-.017.616-.013.299-.034.579-.046.553c-.464 4.785-2.411 6.732-7.196 7.196l-.553.046-.579.034c-.098.005-.198.01-.299.013l-.616.017L12 22l-.642-.005-.616-.017-.299-.013-.579-.034-.553-.046c-4.785-.464-6.732-2.411-7.196-7.196l-.046-.553-.034-.579a28.058 28.058 0 0 1-.013-.299l-.017-.616C2.002 12.432 2 12.218 2 12l.001-.324.004-.318.017-.616.013-.299.034-.579.046-.553c.464-4.785 2.411-6.732 7.196-7.196l.553-.046.579-.034c.098-.005.198-.01.299-.013l.616-.017c.21-.003.424-.005.642-.005zm-1.489 7.14a1 1 0 0 0-1.218 1.567L10.585 12l-1.292 1.293-.083.094a1 1 0 0 0 1.497 1.32L12 13.415l1.293 1.292.094.083a1 1 0 0 0 1.32-1.497L13.415 12l1.292-1.293.083-.094a1 1 0 0 0-1.497-1.32L12 10.585l-1.293-1.292-.094-.083z"/></svg>
                        <svg v-if="this.countPersons != ''" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#047857" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="icon valid icon-tabler icon-tabler-circle-check-filled" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z"/><path fill="#047857" stroke="none" d="M17 3.34a10 10 0 1 1-14.995 8.984L2 12l.005-.324A10 10 0 0 1 17 3.34zm-1.293 5.953a1 1 0 0 0-1.32-.083l-.094.083L11 12.585l-1.293-1.292-.094-.083a1 1 0 0 0-1.403 1.403l.083.094 2 2 .094.083a1 1 0 0 0 1.226 0l.094-.083 4-4 .083-.094a1 1 0 0 0-.083-1.32z"/></svg>

                    </label>
                </div>
            </div>
            <div class="ts-trr-time-options">
                <div class="ts-trr-input">
                    <label><span>Hinfahrt Datum*</span>
                        <input v-model="startDate" data-var="startDate" placeholder="Klicken zur Auswahl" type="text" class="dateinput dinphin" />
                        <svg v-if="this.startDate == '' && this.validationError" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="icon icon-tabler icon-tabler-square-rounded-x-filled" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z"/><path fill="red" stroke="none" d="m12 2 .324.001.318.004.616.017.299.013.579.034.553.046c4.785.464 6.732 2.411 7.196 7.196l.046.553.034.579c.005.098.01.198.013.299l.017.616L22 12l-.005.642-.017.616-.013.299-.034.579-.046.553c-.464 4.785-2.411 6.732-7.196 7.196l-.553.046-.579.034c-.098.005-.198.01-.299.013l-.616.017L12 22l-.642-.005-.616-.017-.299-.013-.579-.034-.553-.046c-4.785-.464-6.732-2.411-7.196-7.196l-.046-.553-.034-.579a28.058 28.058 0 0 1-.013-.299l-.017-.616C2.002 12.432 2 12.218 2 12l.001-.324.004-.318.017-.616.013-.299.034-.579.046-.553c.464-4.785 2.411-6.732 7.196-7.196l.553-.046.579-.034c.098-.005.198-.01.299-.013l.616-.017c.21-.003.424-.005.642-.005zm-1.489 7.14a1 1 0 0 0-1.218 1.567L10.585 12l-1.292 1.293-.083.094a1 1 0 0 0 1.497 1.32L12 13.415l1.293 1.292.094.083a1 1 0 0 0 1.32-1.497L13.415 12l1.292-1.293.083-.094a1 1 0 0 0-1.497-1.32L12 10.585l-1.293-1.292-.094-.083z"/></svg>
                        <svg v-if="this.startDate != ''" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#047857" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="icon valid icon-tabler icon-tabler-circle-check-filled" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z"/><path fill="#047857" stroke="none" d="M17 3.34a10 10 0 1 1-14.995 8.984L2 12l.005-.324A10 10 0 0 1 17 3.34zm-1.293 5.953a1 1 0 0 0-1.32-.083l-.094.083L11 12.585l-1.293-1.292-.094-.083a1 1 0 0 0-1.403 1.403l.083.094 2 2 .094.083a1 1 0 0 0 1.226 0l.094-.083 4-4 .083-.094a1 1 0 0 0-.083-1.32z"/></svg>
                    </label>
                </div>
                <div class="ts-trr-input">
                    <label><span>Hinfahrt Uhrzeit*</span>
                        <input v-model="startTime" data-var="startTime" placeholder="Klicken zur Auswahl" type="text" class="timepicker" />
                        <svg v-if="this.startTime == '' && this.validationError" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="icon icon-tabler icon-tabler-square-rounded-x-filled" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z"/><path fill="red" stroke="none" d="m12 2 .324.001.318.004.616.017.299.013.579.034.553.046c4.785.464 6.732 2.411 7.196 7.196l.046.553.034.579c.005.098.01.198.013.299l.017.616L22 12l-.005.642-.017.616-.013.299-.034.579-.046.553c-.464 4.785-2.411 6.732-7.196 7.196l-.553.046-.579.034c-.098.005-.198.01-.299.013l-.616.017L12 22l-.642-.005-.616-.017-.299-.013-.579-.034-.553-.046c-4.785-.464-6.732-2.411-7.196-7.196l-.046-.553-.034-.579a28.058 28.058 0 0 1-.013-.299l-.017-.616C2.002 12.432 2 12.218 2 12l.001-.324.004-.318.017-.616.013-.299.034-.579.046-.553c.464-4.785 2.411-6.732 7.196-7.196l.553-.046.579-.034c.098-.005.198-.01.299-.013l.616-.017c.21-.003.424-.005.642-.005zm-1.489 7.14a1 1 0 0 0-1.218 1.567L10.585 12l-1.292 1.293-.083.094a1 1 0 0 0 1.497 1.32L12 13.415l1.293 1.292.094.083a1 1 0 0 0 1.32-1.497L13.415 12l1.292-1.293.083-.094a1 1 0 0 0-1.497-1.32L12 10.585l-1.293-1.292-.094-.083z"/></svg>
                        <svg v-if="this.startTime != ''" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#047857" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="icon valid icon-tabler icon-tabler-circle-check-filled" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z"/><path fill="#047857" stroke="none" d="M17 3.34a10 10 0 1 1-14.995 8.984L2 12l.005-.324A10 10 0 0 1 17 3.34zm-1.293 5.953a1 1 0 0 0-1.32-.083l-.094.083L11 12.585l-1.293-1.292-.094-.083a1 1 0 0 0-1.403 1.403l.083.094 2 2 .094.083a1 1 0 0 0 1.226 0l.094-.083 4-4 .083-.094a1 1 0 0 0-.083-1.32z"/></svg>
                    </label>
                </div>
            </div>
            <div style="margin: .5rem 0; display: inline-block;">
                <input id="wayback" type="checkbox" v-model="transportBack">
                <label for="wayback">Rückfahrt einplanen?</label>
            </div>
            <div v-if="transportBack" style="margin-top: 0;" class="ts-trr-time-options">
                <div class="ts-trr-input">
                    <label><span>Rükfahrt Datum*</span>
                        <input v-model="endDate" data-var="endDate" placeholder="Klicken zur Auswahl" type="text" class="dateinput dinpzur" />
                        <svg v-if="this.endDate == '' && this.validationError" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="icon icon-tabler icon-tabler-square-rounded-x-filled" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z"/><path fill="red" stroke="none" d="m12 2 .324.001.318.004.616.017.299.013.579.034.553.046c4.785.464 6.732 2.411 7.196 7.196l.046.553.034.579c.005.098.01.198.013.299l.017.616L22 12l-.005.642-.017.616-.013.299-.034.579-.046.553c-.464 4.785-2.411 6.732-7.196 7.196l-.553.046-.579.034c-.098.005-.198.01-.299.013l-.616.017L12 22l-.642-.005-.616-.017-.299-.013-.579-.034-.553-.046c-4.785-.464-6.732-2.411-7.196-7.196l-.046-.553-.034-.579a28.058 28.058 0 0 1-.013-.299l-.017-.616C2.002 12.432 2 12.218 2 12l.001-.324.004-.318.017-.616.013-.299.034-.579.046-.553c.464-4.785 2.411-6.732 7.196-7.196l.553-.046.579-.034c.098-.005.198-.01.299-.013l.616-.017c.21-.003.424-.005.642-.005zm-1.489 7.14a1 1 0 0 0-1.218 1.567L10.585 12l-1.292 1.293-.083.094a1 1 0 0 0 1.497 1.32L12 13.415l1.293 1.292.094.083a1 1 0 0 0 1.32-1.497L13.415 12l1.292-1.293.083-.094a1 1 0 0 0-1.497-1.32L12 10.585l-1.293-1.292-.094-.083z"/></svg>
                        <svg v-if="this.endDate != ''" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#047857" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="icon valid icon-tabler icon-tabler-circle-check-filled" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z"/><path fill="#047857" stroke="none" d="M17 3.34a10 10 0 1 1-14.995 8.984L2 12l.005-.324A10 10 0 0 1 17 3.34zm-1.293 5.953a1 1 0 0 0-1.32-.083l-.094.083L11 12.585l-1.293-1.292-.094-.083a1 1 0 0 0-1.403 1.403l.083.094 2 2 .094.083a1 1 0 0 0 1.226 0l.094-.083 4-4 .083-.094a1 1 0 0 0-.083-1.32z"/></svg>
                    </label>
                </div>
                <div class="ts-trr-input">
                    <label><span>Rückfahrt Uhrzeit*</span>
                        <input v-model="endTime" data-var="endTime" placeholder="Klicken zur Auswahl" type="text" class="timepicker" />
                        <svg v-if="this.endTime == '' && this.validationError" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="icon icon-tabler icon-tabler-square-rounded-x-filled" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z"/><path fill="red" stroke="none" d="m12 2 .324.001.318.004.616.017.299.013.579.034.553.046c4.785.464 6.732 2.411 7.196 7.196l.046.553.034.579c.005.098.01.198.013.299l.017.616L22 12l-.005.642-.017.616-.013.299-.034.579-.046.553c-.464 4.785-2.411 6.732-7.196 7.196l-.553.046-.579.034c-.098.005-.198.01-.299.013l-.616.017L12 22l-.642-.005-.616-.017-.299-.013-.579-.034-.553-.046c-4.785-.464-6.732-2.411-7.196-7.196l-.046-.553-.034-.579a28.058 28.058 0 0 1-.013-.299l-.017-.616C2.002 12.432 2 12.218 2 12l.001-.324.004-.318.017-.616.013-.299.034-.579.046-.553c.464-4.785 2.411-6.732 7.196-7.196l.553-.046.579-.034c.098-.005.198-.01.299-.013l.616-.017c.21-.003.424-.005.642-.005zm-1.489 7.14a1 1 0 0 0-1.218 1.567L10.585 12l-1.292 1.293-.083.094a1 1 0 0 0 1.497 1.32L12 13.415l1.293 1.292.094.083a1 1 0 0 0 1.32-1.497L13.415 12l1.292-1.293.083-.094a1 1 0 0 0-1.497-1.32L12 10.585l-1.293-1.292-.094-.083z"/></svg>
                        <svg v-if="this.endTime != ''" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#047857" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="icon valid icon-tabler icon-tabler-circle-check-filled" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z"/><path fill="#047857" stroke="none" d="M17 3.34a10 10 0 1 1-14.995 8.984L2 12l.005-.324A10 10 0 0 1 17 3.34zm-1.293 5.953a1 1 0 0 0-1.32-.083l-.094.083L11 12.585l-1.293-1.292-.094-.083a1 1 0 0 0-1.403 1.403l.083.094 2 2 .094.083a1 1 0 0 0 1.226 0l.094-.083 4-4 .083-.094a1 1 0 0 0-.083-1.32z"/></svg>
                    </label>
                </div>
            </div>
            <hr />
            <div v-if="validData" class="ts-trr-route-data">
                <div class="ts-trr-data">
                    <div class="data-stack">
                        <div><strong>Entfernung:</strong> <span>{{ this.routeData?.distance?.text }}</span></div>
                        <div class="d-none"><strong>Reisedauer:</strong> <span>mind. {{ this.routeData?.duration?.text }}</span></div>
                        <div class="d-none"><strong>Ankunft:</strong> <span>{{ this.formatDate(getEstimatedArrivalDate(getDateObject(startDate, startTime), this.routeData?.duration?.value)) }} ca. {{ this.formatTime(getEstimatedArrivalDate(getDateObject(startDate, startTime), this.routeData?.duration?.value)) }} Uhr</span></div>
                        <div class="d-none" v-if="transportBack"><strong>Rückkunft:</strong> <span>{{ this.formatDate(getEstimatedArrivalDate(getDateObject(endDate, endTime), this.routeData?.duration?.value)) }} ca. {{ this.formatTime(getEstimatedArrivalDate(getDateObject(endDate, endTime), this.routeData?.duration?.value)) }} Uhr</span></div>
                        <div style="display: inline-flex; gap: 0 .5rem; align-items: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M3 7l6 -3l6 3l6 -3l0 13l-6 3l-6 -3l-6 3l0 -13"></path>
                                <path d="M9 4l0 13"></path>
                                <path d="M15 7l0 13"></path>
                            </svg>
                            <u style="cursor: pointer;" @click="this.showMap = !this.showMap">Karte {{ this.showMap ? 'verstecken' : 'anzeigen' }}</u>
                        </div>
                    </div>
                    <div :class="{ active: this.showMap }" class="mapcontainer">
                        <div id="routemap"></div>
                    </div>
                </div>
                <hr />
                <div>
                    <div style="margin: .5rem 0; display: inline-block;">
                        <input id="kmAtLocation" type="checkbox" v-model="kmAtLocationActive">
                        <label for="kmAtLocation">Bus wird vor Ort benötigt</label>
                    </div><br />
                    <div v-if="kmAtLocationActive" class="ts-trr-input">
                        <label><span>km vor Ort</span>
                            <input v-model="this.kmAtLocation" type="number" placeholder="25" />
                        </label>
                    </div>
                </div>
                <hr />
                <div>
                    <div style="margin: .5rem 0; display: inline-block;">
                        <input id="stopOver" type="checkbox" v-model="stopOverActive">
                        <label for="stopOver">Zwischenstops einplanen</label>
                    </div><br />
                    <div class="stopOverContainer" v-if="stopOverActive">
                        <div v-for="(stop, index) in stopOvers" style="padding: 1rem; position: relative;" :style="{ zIndex: 250 - (index + 1)}" class="flex1">
                            <div style="font-size: 1.2rem; font-weight: 300; margin-bottom: .25rem;">Zwischenstop {{ index + 1 }}:</div>
                            <div style="display: flex; align-items: center; flex-wrap: wrap; gap: 1rem;">
                                <div class="ts-trr-input" style="flex: 1;">
                                    <label><span>Ort / Adresse *</span>
                                        <input v-model="stop.location" @keydown="startedPlaceTyping('stopOvers[' + index + '].inputLoading', 'stopOvers[' + index + '].locationObj')" @keyup="endedPlaceTyping('stopOvers[' + index + '].location')" type="text" placeholder="Ort / PLZ / Straße" />
                                        <svg v-if="stop.locationObj" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#047857" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="icon valid icon-tabler icon-tabler-circle-check-filled" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z"/><path fill="#047857" stroke="none" d="M17 3.34a10 10 0 1 1-14.995 8.984L2 12l.005-.324A10 10 0 0 1 17 3.34zm-1.293 5.953a1 1 0 0 0-1.32-.083l-.094.083L11 12.585l-1.293-1.292-.094-.083a1 1 0 0 0-1.403 1.403l.083.094 2 2 .094.083a1 1 0 0 0 1.226 0l.094-.083 4-4 .083-.094a1 1 0 0 0-.083-1.32z"/></svg>
                                        <svg v-if="!stop.locationObj && this.validationError" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="icon icon-tabler icon-tabler-square-rounded-x-filled" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z"/><path fill="red" stroke="none" d="m12 2 .324.001.318.004.616.017.299.013.579.034.553.046c4.785.464 6.732 2.411 7.196 7.196l.046.553.034.579c.005.098.01.198.013.299l.017.616L22 12l-.005.642-.017.616-.013.299-.034.579-.046.553c-.464 4.785-2.411 6.732-7.196 7.196l-.553.046-.579.034c-.098.005-.198.01-.299.013l-.616.017L12 22l-.642-.005-.616-.017-.299-.013-.579-.034-.553-.046c-4.785-.464-6.732-2.411-7.196-7.196l-.046-.553-.034-.579a28.058 28.058 0 0 1-.013-.299l-.017-.616C2.002 12.432 2 12.218 2 12l.001-.324.004-.318.017-.616.013-.299.034-.579.046-.553c.464-4.785 2.411-6.732 7.196-7.196l.553-.046.579-.034c.098-.005.198-.01.299-.013l.616-.017c.21-.003.424-.005.642-.005zm-1.489 7.14a1 1 0 0 0-1.218 1.567L10.585 12l-1.292 1.293-.083.094a1 1 0 0 0 1.497 1.32L12 13.415l1.293 1.292.094.083a1 1 0 0 0 1.32-1.497L13.415 12l1.292-1.293.083-.094a1 1 0 0 0-1.497-1.32L12 10.585l-1.293-1.292-.094-.083z"/></svg>
                                        <img v-if="stop.inputLoading" class="loader" src="/wp-content/themes/travelshop/assets/img/loading-dots-gray.svg" alt="loading" />
                                    </label>
                                    <div class="ts-trr-predictions">
                                        <div v-if="predirectionsStatus == 'ZERO_RESULTS'">
                                            <strong>Keine Ergebnisse</strong>
                                        </div>
                                        <div v-for="pred in predictions" @mouseDown="this.processAddress(stop, pred)">
                                            <strong>{{ pred.structured_formatting.main_text }}</strong><br />
                                            <small>{{ pred.structured_formatting.secondary_text }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div style="margin: .25rem 0; display: inline-block;">
                                        <input :id="'wayforth' + index" type="checkbox" v-model="stop.wayForth">
                                        <label :for="'wayforth' + index">auf Hinfahrt</label>
                                    </div><br />
                                    <div v-if="this.transportBack" style="margin: .25rem 0; display: inline-block;">
                                        <input :id="'wayback' + index" type="checkbox" v-model="stop.wayBack">
                                        <label :for="'wayback' + index">auf Rückfahrt</label>
                                    </div>
                                </div>
                                <div :style="{ opacity: index > 0 ? '100%' : '0', pointerEvents: index > 0 ? 'all' : 'none', height: index > 0 ? 'auto' : '0px' }">
                                    <div style="margin: 0 0 .5rem 0;" @click="this.deleteStopOver(index)" class="btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#dc2626" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="icon icon-tabler icon-tabler-trash" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z"/><path d="M4 7h16M10 11v6M14 11v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/></svg>
                                        <span>Stop {{ index + 1 }} löschen</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div @click="this.addStopOver" style="margin: 1rem 0 .5rem 0;" class="btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#65a30d" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="icon icon-tabler icon-tabler-plus" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z"/><path d="M12 5v14M5 12h14"/></svg>
                            <span>Zwischenstop hinzufügen</span>
                        </div>
                    </div>
                </div>
                <hr />
                <div style="display: flex;" class="ts-trr-input">
                    <label><span>Anmerkungen/Wünsche</span>
                        <textarea placeholder="Hier ist Platz für Ihre Anmerkungen" v-model="notes"></textarea>
                    </label>
                </div>
            </div>
            <div style="display: flex; flex-direction: column; align-items: flex-end; justify-content: center;">
                <hr />
                <span v-if="this.validationError" style="font-size: 13px; margin-bottom: 1rem;">
                    <span v-if="!validData">* Bitte Start-/Endpunkt eingeben und aus Liste wählen.<br /></span>
                    <span v-if="this.countPersons == ''">* Bitte Anzahl der zu befördernden Personen wählen.<br /></span>
                    <span v-if="this.startDate == ''">* Bitte Start-Datum auswählen<br /></span>
                    <span v-if="this.startTime == ''">* Bitte Start-Uhrzeit auswählen<br /></span>
                    <span v-if="this.transportBack && this.endDate == ''">* Bitte End-Datum auswählen<br /></span>
                    <span v-if="this.transportBack && this.endTime == ''">* Bitte End-Uhrzeit auswählen<br /></span>
                    <span v-if="this.stopOverActive">
                        <span v-for="(stop,index) in this.stopOvers">
                            <span v-if="!stop.locationObj">* Bitte für Zwischenstop {{ index + 1 }} einen gültigen Ort wählen.<br /></span>
                        </span>
                    </span>
                </span>
                <div @click="this.loadNextStep" :class="{ disabled: !(validData && this.countPersons != '' && this.startDate != '' && this.startTime != '' && (this.transportBack ? (this.endDate != '' && this.endTime != '') : true) && ( this.stopOverActive ? this.stopOvers.reduce((accumulator, curr) => { return !curr.locationObj ? false : ( curr.locationObj && accumulator == true ? true : false) }, true) : true)) }" class="button-large">
                    Zum nächsten Schritt
                </div>
            </div>
        </div>
        <div v-if="currentStep == 2 && !this.submitStatus.sent" class="ts-transportation-request-step">
            <div class="ts-trr-heading">
                Ihre Angaben zur Busanfrage
            </div>
            <hr />
            <div class="data-order">
                <div>
                    <span>von</span>
                    <span>{{ this.inputFrom }}</span>
                </div>
                <div>
                    <span>nach</span>
                    <span>{{ this.inputTo }}</span>
                </div>
                <div>
                    <span>Personen</span>
                    <span>{{ this.countPersons }}</span>
                </div>
                <div>
                    <span>Hinfahrt</span>
                    <span>{{ this.startDate }}, {{ this.startTime }} Uhr</span>
                </div>
                <div v-if="transportBack">
                    <span>Rückfahrt</span>
                    <span>{{ this.endDate }}, {{ this.endTime }} Uhr</span>
                </div>
                <div>
                    <span>Bus vor Ort benötigt</span>
                    <span>{{ this.kmAtLocationActive ? 'Ja, ca. ' + this.kmAtLocation + ' km' : 'Nein' }}</span>
                </div>
                <div v-if="this.stopOverActive && this.stopOvers.filter(stop => stop.wayForth).length">
                    <span>Zwischenstops Hinreise</span>
                    <span>
                        <span v-for="stop in this.stopOvers.filter(stop => stop.wayForth)">
                            {{ stop.wayForth ? (stop.locationObj ? stop.location : 'Fehler: Ungültige Adresse') : '' }}
                        </span>
                    </span>
                </div>
                <div v-if="this.stopOverActive && this.stopOvers.filter(stop => stop.wayBack).length">
                    <span>Zwischenstops Rückreise</span>
                    <span>
                        <span v-for="stop in this.stopOvers.filter(stop => stop.wayBack)">
                            {{ stop.wayBack ? (stop.locationObj ? stop.location : 'Fehler: Ungültige Adresse') : '' }}
                        </span>
                    </span>
                </div>
                <div>
                    <span>Anmerkungen</span>
                    <span>
                        {{ this.notes.length ? this.notes : 'Keine Anmerkungen' }}
                    </span>
                </div>
            </div>
            <hr />
            <div class="ts-trr-heading">
                Ihre Kontaktdaten
            </div>
            <hr />
            <div class="row">
                <div class="col-12 col-lg-6">
                    <label>Wir sind</label>
                    <select v-model="contactData.type">
                        <option value="Verein">Verein</option>
                        <option value="Schule">Schule</option>
                        <option value="Firma">Firma</option>
                        <option value="Organisation">Organisation</option>
                        <option value="Privat">Privat</option>
                        <option value="Reisebüro">Reisebüro</option>
                        <option value="Reiseveranstalter">Reiseveranstalter</option>
                    </select>
                </div>
                <div v-if="contactData.type != 'Privat' && contactData.type != ''" class="col-12 col-lg-6">
                    <label>Name {{ contactData.type }}</label>
                    <input type="text" v-model="contactData.typeDesc" />
                </div>
                <div class="col-12 col-lg-6">
                    <label>Anrede</label>
                    <select v-model="contactData.salutation">
                        <option value="Herr">Herr</option>
                        <option value="Frau">Frau</option>
                        <option value="Divers">Divers</option>
                    </select>
                </div>
                <div class="col-12 col-lg-6">
                    <label>Vorname</label>
                    <input type="text" v-model="contactData.firstname" />
                </div>
                <div class="col-12 col-lg-6">
                    <label>Nachname</label>
                    <input type="text" v-model="contactData.lastname" />
                </div>
                <div class="col-12 col-lg-6">
                    <label>Straße, Hausnummer</label>
                    <input type="text" v-model="contactData.address" />
                </div>
                <div class="col-12 col-lg-6">
                    <label>PLZ</label>
                    <input type="text" v-model="contactData.zip" />
                </div>
                <div class="col-12 col-lg-6">
                    <label>Ort</label>
                    <input type="text" v-model="contactData.place" />
                </div>
                <div class="col-12 col-lg-6">
                    <label>Land</label>
                    <select v-model="contactData.country">
                        <option value="Deutschland">Deutschland</option>
                        <option value="Österreich">Österreich</option>
                        <option value="Schweiz">Schweiz</option>
                    </select>
                </div>
                <div class="col-12 col-lg-6">
                    <label>Telefonnummer</label>
                    <input type="text" v-model="contactData.phone" />
                </div>
                <div class="col-12 col-lg-6">
                    <label>E-Mail-Adresse</label>
                    <input type="text" v-model="contactData.email" />
                </div>
            </div>
            <hr />
            <div v-if="!this.submitStatus.sent" style="display: flex; justify-content: space-between;">
                <div @click="this.currentStep = 1;" class="button-large">
                    Zurück zur Routenplanung
                </div>
                <div @click="Object.values(contactData).filter(a => a.length > 0).length == 11 ? this.sendEmail() : null" :class="{ disabled: Object.values(contactData).filter(a => a.length > 0).length < 11 }" class="button-large">
                    {{ Object.values(contactData).filter(a => a.length > 0).length == 11 ? 'Anfrage versenden' : 'Bitte alle Felder ausfüllen' }}
                    <img v-if="submitLoading" style="width: 30px; margin-left: .5rem;" class="loader" src="/wp-content/themes/travelshop/assets/img/loading-dots.svg" alt="loading" />
                </div>
            </div>
        </div>
    </div>
</div>

<script>
String.prototype.toObject = function( obj, value ) {
    var names = this;
    let newObj = obj;
    console.log(names, '164');
    names = names.replace(/\[(\w+)\]/, ".$1");
    names = names.replace(/^\./, "");
    names = names.split(".");
    var lastName = arguments.length === 2 ? names.pop() : false;
    for( var i = 0; i < names.length; i++ ) {
        newObj = newObj[ names[i] ] = newObj[ names[i] ] || {};
    }
    // If a value was given, set it to the last name:
    if( lastName ) newObj = newObj[ lastName ] = value;
    // Return the last object in the hierarchy:
    return obj = newObj;
};
Vue.createApp({
    data() {
        return {
            APIKeyProvided: <?php echo defined('TS_GOOGLEMAPS_API') && !empty(TS_GOOGLEMAPS_API) ? 'true' : 'false'; ?>,
            contactData: {
                type: '',
                typeDesc: ' ',
                salutation: '',
                firstname: '',
                lastname: '',
                address: '',
                zip: '',
                place: '',
                country: 'Deutschland',
                phone: '',
                email: ''
            },
            submitStatus: {
                sent: false,
                message: ''
            },
            submitLoading: false,
            validationError: null,
            validCountries: 'de,ch',
            typingTimer: null,
            doneTypingInterval: 650,
            kmAtLocationActive: false,
            kmAtLocation: 20,
            stopOverActive: false,
            stopOvers: [
                {
                    location: '',
                    locationObj: false,
                    inputLoading: false,
                    wayForth: true,
                    wayBack: false
                }
            ],
            validData: false,
            showMap: true,
            currentStep: 0,
            countPersons: '',
            routeData: {},
            transportBack: false,
            startTime: '',
            startDate: '',
            endTime: '',
            endDate: '',
            inputFrom: '',
            inputFromLoading: false,
            inputFromObj: false,
            inputTo: '',
            inputToLoading: false,
            inputToObj: false,
            predirectionsStatus: '',
            datePickerBack: null,
            notes: '',
            predictions: [

            ],
            currentStep: 1,
            steps: [
                {
                    name: 'Busanfrage',
                    ready: true,
                    valid: false
                },
                {
                    name: 'Kontaktdaten',
                    ready: false,
                    valid: false
                }
            ]
        }
    },
    methods: {
        sendEmail() {
            this.submitLoading = true;
            const data = new FormData();
            data.append( 'action', 'sendrequest' );
            data.append( 'to', '<?php echo $args['emails']; ?>' );
            data.append( 'title', 'Busanfrage über <?php echo get_site_url(); ?>' );
            data.append( 'text', this.getEmailString() );

            fetch('/wp-admin/admin-ajax.php?action=sendrequest', {
                method: 'POST',
                body: data,
            }).then((resp) => {
                if(resp.status == 200) {
                    this.submitStatus.sent = true;
                    this.submitStatus.message = 'Ihre Anfrage wurde erfolgreich verschickt.';
                }
                this.submitLoading = false;
            });
        },
        getEmailString() {
            let string = '';
            string += 'Busanfrage über <?php echo get_site_url(); ?> erhalten:\r\n\r\n';
            string += 'Kontaktdaten:\r\n';
            string += this.contactData.type + ': ' + this.contactData.typeDesc + '\r\n';
            string += this.contactData.salutation + ' ' + this.contactData.firstname + ' ' + this.contactData.lastname + '\r\n';
            string += this.contactData.address + ', ' + this.contactData.zip + ' ' + this.contactData.place + '\r\n';
            string += this.contactData.country + '\r\n\r\n';
            string += 'Telefon: ' + this.contactData.phone + '\r\n';
            string += 'E-Mail-Adresse: ' + this.contactData.email + '\r\n\r\n\r\n';

            string += 'Anfragedaten:\r\n';
            string += 'Von: ' + this.inputFrom + '\r\n';
            string += 'Nach: ' + this.inputTo + '\r\n';
            string += 'Personen: ' + this.countPersons + '\r\n';
            string += 'Hinfahrt: ' + this.startDate + ', ' + this.startTime + ' Uhr\r\n';
            string += this.transportBack ? ('Rückfahrt: ' + this.endDate + ', ' + this.endTime + ' Uhr\r\n') : '';
            string += 'Bus vor Ort benötigt: ' + (this.kmAtLocationActive ? 'Ja, ca. ' + this.kmAtLocation + ' km' : 'Nein') + '\r\n';

            if(this.stopOverActive && this.stopOvers.filter(stop => stop.wayForth).length) {
                string += '\r\nZwischenstops Hinreise:\r\n';
                this.stopOvers.filter(stop => stop.wayForth).forEach((el) => {
                    string += el.location + '\r\n';
                });
            }
            if(this.stopOverActive && this.stopOvers.filter(stop => stop.wayBack).length) {
                string += '\r\nZwischenstops Rückreise:\r\n';
                this.stopOvers.filter(stop => stop.wayBack).forEach((el) => {
                    string += el.location + '\r\n';
                });
            }

            string += '\r\nAnmerkungen:\r\n';
            string += this.notes.length ? this.notes : 'Keine Anmerkungen';
            return string;
        },
        processAddress(stop, pred) {
            stop.location = pred.structured_formatting.main_text + ', ' + pred.structured_formatting.secondary_text; stop.locationObj = pred;
            setTimeout(() => {
                this.initGoogleMap();
            }, 750);
        },
        loadNextStep() {
          if((this.validData && this.countPersons != '' && this.startDate != '' && this.startTime != '' && (this.transportBack ? (this.endDate != '' && this.endTime != '') : true) && (this.stopOverActive ? this.stopOvers.reduce((accumulator, curr) => { return !curr.locationObj ? false : ( curr.locationObj && accumulator == true ? true : false) }, true) : true))) {
              this.steps[this.currentStep].ready = true;
              this.validationError = false;
              this.currentStep++;
          } else {
              this.validationError = true;
          }
        },
        addStopOver() {
            this.stopOvers.push({
                location: '',
                locationObj: false,
                inputLoading: false,
                wayForth: true,
                wayBack: false
            });
        },
        deleteStopOver(index) {
            this.stopOvers.splice(index,1);
            setTimeout(() => {
                this.initGoogleMap();
            }, 750);
        },
        ObjectByString(s) {
            s = s.replace(/\[(\w+)\]/, ".$1");
            s = s.replace(/^\./, "");
            var self = this,
                a = s.split(".");
            for (var i = 0; i < a.length; i++) {
                var k = a[i];
                if (k in self) {
                    self = self[k];
                } else  {
                    return;
                }
            }
            return self;
        },
        set(from, value, selector) {
            selector.toObject(this, value)
        },
        getDateObject(DateString, TimeString) {
            let dateValues = DateString.split('.');
            let timeValues = TimeString.split(':');
            const date = new Date(dateValues[2], parseInt(dateValues[1]) - 1, dateValues[0], timeValues[0], timeValues[1]);
            return date;
        },
        getEstimatedArrivalDate(date, durationInSeconds) {
            return new Date(date.setSeconds(date.getSeconds() + durationInSeconds + 60));
        },
        formatTime(date) {
            var today = date;
            var h = today.getHours().toString().padStart(2, '0');
            var m = today.getMinutes().toString().padStart(2, '0');
            var s = today.getSeconds();
            return h + ":" + m;
        },
        formatDate(inputDate) {
            let date, month, year;

            date = inputDate.getDate();
            month = inputDate.getMonth() + 1;
            year = inputDate.getFullYear();

            date = date
                .toString()
                .padStart(2, '0');

            month = month
                .toString()
                .padStart(2, '0');

            return `${date}.${month}.${year}`;
        },
        startedPlaceTyping(loading, obj) {
            this.set(this, true, loading);
            console.log(loading, '288');
            this.set(this, false, obj);
            clearTimeout(this.typingTimer);
        },
        endedPlaceTyping(term) {
            clearTimeout(this.typingTimer);
            this.typingTimer = setTimeout(() => {
                this.startAutocomplete(this.ObjectByString(term));
            }, this.doneTypingInterval);
        },
        startAutocomplete(term) {
            this.callPlaceAPI('place/autocomplete', term).then(() => {
                this.inputFromLoading = false;
                this.inputToLoading = false;
                this.stopOvers.forEach((stopOv) => {
                    stopOv.inputLoading = false;
                });
            });
        },
        callPlaceAPI: async function(action, term) {
            const response = await fetch('/wp-content/themes/travelshop/google-ajax-endpoint.php?action=' + encodeURIComponent(action) + '&term=' + term + '&countries=' + this.validCountries);
            const jsonData = await response.json();
            this.predirectionsStatus = JSON.parse(jsonData).status;
            this.predictions = JSON.parse(jsonData).predictions;
            //console.log(jsonData);
        },
        callDestinationAPI: async function(action, origin, destination) {
            const response = await fetch('/wp-content/themes/travelshop/google-ajax-endpoint.php?action=' + encodeURIComponent(action) + '&origin=' + origin + '&destination=' + destination);
            const jsonData = await response.json();
            this.routeData = JSON.parse(jsonData).routes[0].legs[0];
            //console.log(jsonData);
        },
        initGoogleMap() {
            var directionsService = new google.maps.DirectionsService();
            var directionsRenderer = new google.maps.DirectionsRenderer();
            var chicago = new google.maps.LatLng(41.850033, -87.6500523);
            var map = new google.maps.Map(document.getElementById('routemap'));
            console.log(this.stopOvers);
            directionsRenderer.setMap(map);
            directionsService.route({
                origin: { placeId: this.inputFromObj.place_id },
                destination: { placeId: this.inputToObj.place_id },
                waypoints: this.stopOvers.filter((x) => {
                    if(typeof x.locationObj.place_id != 'undefined') {
                        return true;
                    } else {
                        return false;
                    }
                }).map((x) => {
                    return {
                        location: { placeId: x.locationObj.place_id },
                        stopover: true
                    }
                }),
                travelMode: 'DRIVING'
            }, function(result, status) {
                if (status == 'OK') {
                    directionsRenderer.setDirections(result);
                }
            });
        },
        initPickers() {
            const dateinputs = document.querySelectorAll('.dateinput');
            let $ = jQuery;
            let startDate = this.startDate == '' ? this.formatDate(new Date()) : this.startDate;
            let parts = startDate.match(/(\d+)/g);
            dateinputs.forEach((inp) => {
                if($(inp).hasClass('dinpzur')) {
                    this.datePickerBack = new Datepicker(inp, {
                        format: 'dd.mm.yyyy',
                        autohide: true,
                        minDate: $(inp).hasClass('dinpzur') ? new Date(parts[2], parts[1]-1, parts[0]) : new Date()
                    });
                } else {
                    new Datepicker(inp, {
                        format: 'dd.mm.yyyy',
                        autohide: true,
                        minDate: $(inp).hasClass('dinpzur') ? new Date(parts[2], parts[1]-1, parts[0]) : new Date()
                    });
                }
                inp.addEventListener('changeDate', (date) => {
                    this[date.target.getAttribute('data-var')] = this.formatDate(date.detail.date);
                    if($(inp).hasClass('dinphin')) {
                        if(this.startDate && document.querySelector('.dinpzur')) {
                            this.datePickerBack?.destroy();
                            let startDate = this.startDate;
                            let parts = startDate.match(/(\d+)/g);
                            this.datePickerBack = new Datepicker(document.querySelector('.dinpzur'), {
                                format: 'dd.mm.yyyy',
                                autohide: true,
                                minDate: new Date(parts[2], parts[1]-1, parts[0])
                            });
                        }
                    }
                });
            });
            let formatTime = this.formatTime;
            let _this = this;
            $('.timepicker').timepicker({
                timeFormat: 'HH:mm',
                interval: 30,
                minTime: '5',
                maxTime: '22',
                startTime: '05:00',
                dynamic: false,
                dropdown: true,
                scrollbar: false,
                change: function(time, e) {
                    _this[$(this).attr('data-var')] = formatTime(time);
                }
            });
        }
    },
    watch: {
        validData: function(newVal) {
            if(!newVal) {
                this.steps.forEach((step, ind) => {
                    if(ind != this.currentStep - 1) {
                        step.ready = false;
                    }
                });
            }
        },
        currentStep: function(newVal) {
            if(newVal == 1) {
                setTimeout(() => {
                    this.initGoogleMap();
                    this.initPickers();
                }, 750);
            }
        },
        inputFromObj: function() {
            if(this.inputToObj && this.inputFromObj) {
                this.callDestinationAPI('directions', this.inputFromObj.place_id, this.inputToObj.place_id);
                this.validData = true;
                setTimeout(() => {
                    this.initGoogleMap();
                }, 750);
            } else {
                this.validData = false;
            }
        },
        inputToObj: function() {
            if(this.inputToObj && this.inputFromObj) {
                this.callDestinationAPI('directions', this.inputFromObj.place_id, this.inputToObj.place_id);
                setTimeout(() => {
                    this.initGoogleMap();
                }, 750);
                this.validData = true;
            } else {
                this.validData = false;
            }
        },
        transportBack: function(val) {
            if(val) {
                setTimeout(() => {
                    this.initPickers();
                }, 500);
            }
        }
    },
    mounted() {
        this.initPickers();
    }
}).mount('#ts-transportation-request-<?php echo $randomHash; ?>')
</script>

<style>
    .flex1 {
        flex: 1;
    }
    .ui-timepicker-container,
    .datepicker {
        z-index: 999 !important;
    }
    #routemap {
        width: 100%;
        height: 250px;
        border-radius: 5px;
        overflow: hidden;
        box-shadow: none;
        transition: 300ms ease-in-out all;
    }
    .mapcontainer.active #routemap {
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    }
    .stopOverContainer>div:nth-child(odd) {
        background: #ffffff;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
    }
    .stopOverContainer>div:nth-child(even) {
        background: #f4f4f5;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
    }
    .mapcontainer {
        height: 0;
        overflow: hidden;
        transition: 300ms ease-in-out all;
        flex: 1;
        opacity: 0;
        min-width: 250px;
    }
    .mapcontainer.active {
        height: 250px;
        opacity: 1;
    }
    .data-order {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
    }
    .data-order>div {
        min-width: 33%;
        max-width: 66%;
        display: flex;
        flex-direction: column;
        padding: .7rem;
    }
    .data-order>div>span {
        display: inline-block;
        max-width: 325px;
    }
    .data-order>div>span:first-child {
        color: #e30613;
    }
    .data-order>div>span:last-child {
        font-weight: 300;
        display: flex;
        flex-direction: column;
    }
    .data-order>div>span:last-child span {
        display: inline-block;
        line-height: 1.2;
        max-width: 250px;
        padding: 0.25rem 0;
    }
    .ts-trr-error {
        background: #ea580c;
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 5px;
        display: inline-block;
    }
    .ts-trr-input {
        position: relative;
        display: inline-flex;
    }
    .ts-trr-input .valid {
        position: absolute;
        top: 0;
        right: 0;
        transform: translate(35%, -35%);
    }
    .ts-trr-input .loader {
        position: absolute;
        width: calc(25px + .5rem);
        height: 26px;
        padding: 0 .25rem;
        background: #fff;
        right: .5rem;
        top: calc(1.25rem + 13px);
        transform: translateY(-50%);
    }
    .ts-trr-input label {
        border: 2px solid #ddd;
        background: #fff;
        width: 100%;
        border-radius: 0;
        padding: 1.25rem .5rem 0 .5rem;
        /* box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); */
        position: relative;
        transition: 300ms ease-in-out all;
        margin: 0;
        display: flex;
    }
    .button-large {
        background: #e30613;
        color: white;
        padding: .75rem 1.25rem;
        cursor: pointer;
        display: inline-block;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    }
    .button-large.disabled {
        background: #6b7280;
    }
    .button-large:hover {
        background: #a6050f;
    }
    .button-large.disabled:hover {
        background: #4b5563;
    }
    .ts-trr-input label textarea {
        min-height: 150px;
    }
    .ts-trr-input label input,
    .ts-trr-input label textarea {
        margin: 0 -.5rem;
        padding: .2rem .5rem;
        border-radius: 0;
        width: 100%;
        min-width: 220px;
        flex: 1;
        font-size: 1rem;
    }
    .ts-trr-input label:focus,
    .ts-trr-input label:focus-within {
        border-color: #e30613;
    }
    .ts-trr-input label>span {
        font-size: .75rem;
        font-weight: bold;
        position: absolute;
        padding: .1rem .5rem;
        top: 0;
        left: 0;
    }
    .ts-trr-input input,
    .ts-trr-input input:active,
    .ts-trr-input input:focus,
    .ts-trr-input textarea,
    .ts-trr-input textarea:focus,
    .ts-trr-input textarea:active {
        border: 0;
        outline: 0;
    }
    .ts-trr-route-options {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        padding: .5rem 0;
    }
    .ts-trr-time-options {
        display: flex;
        justify-content: flex-start;
        flex-wrap: wrap;
        gap: 1rem;
        padding: .5rem 0;
    }
    .ts-trr-route-data {
        padding: 0;
    }
    .ts-trr-data {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        gap: 2rem;
    }
    .data-stack {
        font-size: 1.1rem;
        font-weight: 300;
    }
    .ts-trr-predictions {
        position: absolute;
        top: 105%;
        left: 0;
        right: 0;
        background: #fff;
        z-index: 999;
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        display: none;
    }
    .ts-trr-input:focus .ts-trr-predictions,
    .ts-trr-input:focus-within .ts-trr-predictions {
        display: block;
    }
    .ts-trr-predictions>div {
        font-size: .8rem;
        border-bottom: 1px solid #cbd5e1;
        padding: 0.4rem 0.5rem 0.3rem 0.5rem;
        line-height: 1;
        cursor: pointer;
    }
    .ts-trr-predictions>div:hover {
        background: #e2e8f0;
    }
    .ts-trr-predictions>div * {
        pointer-events: none;
    }
    .ts-transportation-request .row>div {
        display: flex;
        flex-direction: column;
    }
    .ts-transportation-request .row>div label {
        font-size: .85rem;
        font-weight: bold;
    }
    .ts-transportation-request .row>div input,
    .ts-transportation-request .row>div select {
        padding: .3rem 1rem;
        font-size: 1.1rem;
        font-weight: 300;
        margin-bottom: 1rem;
        min-height: 40px;
        width: 100%;
        border: 1px solid #d1d5db;
        outline: 0;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    }
    .ts-transportation-request .btn {
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        border: 1px solid #cbd5e1;
        background: #f1f5f9;
        color: #333;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0 .25rem;
    }
    .ts-transportation-request .btn:hover {
        background: #cbd5e1;
    }
    .ts-transportation-request {
        border: 1px solid #e2e8f0;
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        padding: 1rem;
        border-radius: 5px;
    }
    .ts-transportation-request .ts-transportation-request-steps {
        display: flex;
        flex-wrap: wrap;
        margin: -1rem -1rem 0 -1rem;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        padding: 1.5rem 2rem;
    }
    .ts-transportation-request .ts-transportation-request-steps .ts-trr-step {
        display: inline-flex;
        align-items: center;
        margin-right: 1.5rem;
        padding: .25rem 0;
        font-size: 1.1rem;
    }
    .ts-transportation-request .ts-transportation-request-steps .ts-trr-step:last-child {
        margin-right: 0;
    }
    .ts-transportation-request .ts-transportation-request-steps .ts-trr-step>div:first-child {
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        background: #e30613;
        color: #fff;
        display: inline-flex;
        width: 40px;
        height: 40px;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-right: .5rem;
    }
    .ts-transportation-request .ts-transportation-request-steps .ts-trr-step.disabled {
        opacity: .95;
        color: #94a3b8;
    }
    .ts-transportation-request .ts-transportation-request-steps .ts-trr-step.done>div:first-child {
        background: #fff;
        border: 2px solid #e30613;
        color: #333;
    }
    .ts-transportation-request .ts-transportation-request-steps .ts-trr-step.disabled>div:first-child {
        background: #cbd5e1;
    }
    .ts-transportation-request-step {
        padding: 2rem 1rem;
    }
    .ts-transportation-request-step .ts-trr-heading {
        font-size: 1.6rem;
        text-transform: uppercase;
        color: #e30613;
        letter-spacing: .1rem;
    }
    .ts-trr-route-options {
        padding: .5rem 0;
    }
    [type="checkbox"] {
        position: relative;
        left: 30px;
        top: 0px;
        z-index: 0;
        -webkit-appearance: none;
        display: none;
    }
    [type="checkbox"] + label {
        position: relative;
        display: block;
        cursor: pointer;
        font-family: sans-serif;
        font-size: 1rem;
        line-height: 1.4;
        padding-left:50px;
        position: relative;
        margin: 0;
    }
    [type="checkbox"] + label:before {
        width: 40px;
        height: 20px;
        border-radius: 30px;
        border: 2px solid #ddd;
        background-color: #EEE;
        content: "";
        margin-right: 15px;
        transition: background-color 0.5s linear;
        z-index: 5;
        position: absolute;
        left: 0px;
    }
    [type="checkbox"] + label:after {
        width: 16px;
        height: 16px;
        border-radius: 30px;
        background-color: #fff;
        content: "";
        transition: margin 0.1s linear;
        box-shadow: 0px 0px 5px #aaa;
        position: absolute;
        left: 2px;
        top: 2px;
        z-index: 10;
    }
    [type="checkbox"]:checked + label:before {
        background-color: #047857;
    }
    [type="checkbox"]:checked + label:after {
        margin: 0 0 0 20px;
    }
</style>