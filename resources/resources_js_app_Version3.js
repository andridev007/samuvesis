import './bootstrap'

if ('serviceWorker' in navigator) {
  // vite-plugin-pwa will auto register
}

window.copyToClipboard = function(text) {
  navigator.clipboard.writeText(text).then(() => {
    alert('Copied!')
  }).catch(()=> alert('Failed copy'))
}