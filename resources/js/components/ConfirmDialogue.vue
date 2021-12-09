<template>
    <div id="confirm-modal" role="dialog" class="fade ModalConfirmationGeneral_modalBody modal show" tabindex="-1" aria-hidden="true">
        <div role="document" class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="ModalConfirmationGeneral_content">{{ this.message }}</div>
                    <div class="ModalConfirmationGeneral_btnContainer">
                        <button class="btn btn-light ModalConfirmationGeneral_btn ModalConfirmationGeneral_btnGrey mr-2" data-dismiss="modal" aria-label="Close" @click="cancel">Tidak</button>
                        <button class="btn btn-light ModalConfirmationGeneral_btn ModalConfirmationGeneral_btnDanger" data-dismiss="modal" aria-label="Close" @click="confirm">Ya</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ConfirmDialogue',
    data: () => ({
        message: undefined,
        resolvePromise: undefined,
        rejectPromise: undefined,
    }),
    methods: {
        show(options = {}) {
            this.message = options.message;
            return new Promise((resolve, reject) => {
                this.resolvePromise = resolve
                this.rejectPromise = reject
            })
        },
        confirm() {
            this.resolvePromise(true)
        },
        cancel() {
            this.resolvePromise(false)
        },
    }
}
</script>
