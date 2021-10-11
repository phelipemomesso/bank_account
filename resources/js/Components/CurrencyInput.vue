<template>
    <input
        class="
            border-gray-300
            focus:border-indigo-300
            focus:ring
            focus:ring-indigo-200
            focus:ring-opacity-50
            rounded-md
            shadow-sm
        "
        ref="inputRef"
        type="text"
        :value="formattedValue"
    />
</template>

<script>
import { useCurrencyInput } from "vue-currency-input";

export default {
    name: "CurrencyInput",
    props: {
        modelValue: Number,
        options: Object,
    },
    setup(props) {
        const { formattedValue, inputRef } = useCurrencyInput(props.options);

        return { inputRef, formattedValue };
    },
};
</script>
