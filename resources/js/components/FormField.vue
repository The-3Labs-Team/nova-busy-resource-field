<template>
  <DefaultField
    :field="field"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <div class="flex items-center">
        <svg v-if="isBusy" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path :class="isBusyByCurrentUser ? 'text-blue-500' : 'text-red-500'"
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
        <span class="ml-2">{{ isBusy ? (isBusyByCurrentUser ? 'Busy (You)' : 'Busy') : 'Free' }}</span>
      </div>
    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resource', 'resourceId', 'field'],

  data() {
    return {
      isBusy: false,
      isBusyByCurrentUser: false,
    }
  },

  methods: {
    setInitialValue() {
      this.value = this.field.value || ''
    },

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
          this.isBusy = true;
          this.isBusyByCurrentUser = responseData.data.pivot.user_id === this.$page.props.currentUser.id;
          
          if (this.isBusyByCurrentUser) {
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
      this.field.saveEvery ?? 2000 // 2 seconds
      )
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
