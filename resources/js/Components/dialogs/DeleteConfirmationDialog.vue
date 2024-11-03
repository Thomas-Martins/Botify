<script setup>
import {defineEmits, defineProps} from 'vue';

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false
    },
    text: {
        type: String,
        default: 'Êtes-vous sûr de vouloir continuer ?'
    }
});

// Emit event to update the modelValue
const emit = defineEmits(['update:modelValue']);

// Function to close the dialog
const closeDialog = () => {
    emit('update:modelValue', false);
};

const confirmAction = () => {
    // Add any confirm action logic here
    emit('update:modelValue', false);
    emit('delete',)
};
</script>

<template>
    <!-- Bind dialog visibility using modelValue and emit changes with update:modelValue -->
    <v-dialog width="auto"
              :model-value="modelValue" @update:model-value="emit('update:modelValue', $event)">
        <v-card max-width="400">
            <v-card-text>
                {{ text }}
            </v-card-text>
            <v-card-actions>
                <v-btn color="red" @click="closeDialog">Annuler</v-btn>
                <v-btn color="green" @click="confirmAction">Confirmer</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<style scoped>
</style>
