<template>
    <select class="form-control">
        <slot></slot>
    </select>
</template>

<script>
import Select2 from 'select2'
export default {
    props: [
        'options',
        'value'
    ],
    mounted() {
        var vm = this;

        $(this.$el).select2({
            theme: 'bootstrap',
            data: this.options
        })
        .val(this.value)
        .trigger('change')
        .on('change', function() {
            vm.$emit('input', this.value);
        });
    },
    watch: {
        value: function(param) {
            $(this.$el).val(param).trigger('change');
        },
        options: function(param) {
            var option = $('<option></option>').attr({'selected':'selected', 'disabled':'disabled'}).text("Pilih " + param.name);
            $(this.$el).empty().append(option)
            .select2({
                theme: 'bootstrap',
                data: param.data
            });
        },
        destroyed: function() {
            $(this.$el).off().select2('destroy');
        }
    }
}
</script>
