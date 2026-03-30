const { spawnSync } = require('node:child_process')
const resolveNovaPath = require('./resolve-nova-path')

const result = spawnSync('npm', ['ci', '--prefix', resolveNovaPath()], {
  stdio: 'inherit',
})

process.exit(result.status ?? 1)
