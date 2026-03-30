const fs = require('node:fs')
const path = require('node:path')

function resolveNovaPath() {
  if (process.env.NOVA_VENDOR_PATH) {
    return process.env.NOVA_VENDOR_PATH
  }

  const candidates = [
    path.resolve(__dirname, '..', 'vendor/laravel/nova'),
    path.resolve(__dirname, '..', '..', '..', 'vendor/laravel/nova'),
  ]

  const existingPath = candidates.find(candidate => fs.existsSync(candidate))

  if (!existingPath) {
    throw new Error(
      'Unable to locate laravel/nova. Set NOVA_VENDOR_PATH or install Nova in vendor/.'
    )
  }

  return existingPath
}

module.exports = resolveNovaPath

if (require.main === module) {
  process.stdout.write(resolveNovaPath())
}
