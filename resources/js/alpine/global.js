export default function header(){
    return {
        msg: null,
        open: false,
        toggle() { this.open = !this.open }
    }
}

