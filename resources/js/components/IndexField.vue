<template>

    <div v-if="fieldData" :class=" 'details-box-'+fieldData.pivot.busiable_id"
         class="absolute bg-white p-4 rounded-lg shadow-lg hidden"
         style="transform: translate(40px, -25px); z-index: 5;">

        <div class="absolute"
             style="top: 50%; right: 100%; transform: translateY(-50%); border-top: 10px solid transparent; border-right: 20px solid white; border-bottom: 10px solid transparent;"></div>

        <p class="relative z-2">
            <span class="text-base">Occupied by <span class="font-bold">{{ fieldData.name }}</span></span>
            <br>
            <span class="text-xs tracking-wide">Last activity: {{ lastUpdate }}</span>
        </p>
    </div>

    <svg v-if="fieldValue === 'Busy'" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" @mouseout="showDetails" @mouseover="showDetails">
        <path class="text-red-500"
              d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"
              stroke-linecap="round"
              stroke-linejoin="round"/>
    </svg>

    <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
         xmlns="http://www.w3.org/2000/svg">
        <path
            d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"
            stroke-linecap="round" stroke-linejoin="round"
            style="color: #b5b5b5;"/>
    </svg>

</template>

<script>
export default {
    props: ['resourceName', 'resource', 'field'],

    data() {
        return {
            fieldValue: null,
            fieldData: null,
            lastUpdate: null
        };
    },

    methods: {
        async fetchData() {
            try {
                const response = await fetch('/nova-vendor/the-3labs-team/nova-busy-resource-field/is-busy', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        'model-id': this.resource.id.value,
                        'model-name': this.$page.props.resourceName,
                    }),
                });

                const responseData = await response.json();

                if (responseData.success) {
                    this.fieldValue = 'Busy';
                    this.fieldData = responseData.data;
                    this.lastUpdate = responseData.lastUpdate;
                    this.setTableRowBgColor(this.fieldData.pivot.busiable_id);
                } else {
                    this.fieldValue = 'Free';
                }
            } catch (error) {
                console.error(error);
                this.fieldValue = 'Error';
            }
        },

        showDetails() {
            const detailsBox = document.querySelector('.details-box-' + this.fieldData.pivot.busiable_id);

            detailsBox.classList.toggle('hidden');
        },

        setTableRowBgColor(id) {
            const tableRow = document.querySelector(`[dusk="${id}-row"]`);

            tableRow.style.backgroundColor = 'rgba(255, 0, 0, 0.03)';
            tableRow.classList.remove('group');
        }

    },

    mounted() {
        this.fetchData();
    }
};
</script>
