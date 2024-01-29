<template>
    <!--  <DefaultField-->
    <!--    :field="field"-->
    <!--    :errors="errors"-->
    <!--    :show-help-text="showHelpText"-->
    <!--    :full-width-content="fullWidthContent"-->
    <!--  >-->
    <!--    <template #field>-->
    <!--      <input-->
    <!--        :id="field.attribute"-->
    <!--        type="text"-->
    <!--        class="w-full form-control form-input form-input-bordered"-->
    <!--        :class="errorClasses"-->
    <!--        :placeholder="field.name"-->
    <!--        v-model="value"-->
    <!--      />-->
    <!--    </template>-->
    <!--  </DefaultField>-->
</template>

<script>
import {FormField, HandlesValidationErrors} from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resource', 'resourceId', 'field'],

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || ''
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.fieldAttribute, this.value || '')
        },

        async checkIfIsNotBusy() {

            try {
                const response = await fetch('/nova-vendor/the-3labs-team/nova-busy-resource-field/is-busy', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        'model-id': this.$page.props.resourceId,
                        'model-name': this.$page.props.resourceName,
                    }),
                });

                const responseData = await response.json();


                if (responseData.success) {
                    if (responseData.data.pivot.user_id === this.$page.props.currentUser.id) {
                        return true;
                    }
                    return confirm('This resource is busy, do you want to proceed?')
                }

                return true;

            } catch (error) {
                console.error(error);
                this.fieldValue = 'Error';
            }

        },

        async storeAccess() {

            const response = await fetch('/nova-vendor/the-3labs-team/nova-busy-resource-field/store-busy', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    'model-id': this.$page.props.resourceId,
                    'model-name': this.$page.props.resourceName,
                    'user-id': this.$page.props.currentUser.id,
                }),
            })
        },

        async updateAccess() {
            setInterval(async () => {

                    await this.storeAccess()

                },
                this.field.saveEvery ?? 2000 // 30 seconds
            ) // 30 seconds
        }


    },

    mounted() {
        this.checkIfIsNotBusy().then((userConfirmed) => {
            if (userConfirmed) {
                this.storeAccess();
                this.updateAccess();
            } else {
                window.history.back();
            }
        });
    },

}
</script>
