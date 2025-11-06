@php
    $cliente = $cliente ?? null;
    $nascimentoValue = old('nascimento', optional(optional($cliente)->nascimento)->format('Y-m-d'));
    $formatCpf = static function ($value) {
        $digits = preg_replace('/\D/', '', (string) $value);
        if (strlen($digits) !== 11) {
            return $value ?? '';
        }

        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $digits);
    };
    $formatPhone = static function ($value) {
        $digits = preg_replace('/\D/', '', (string) $value);

        if (strlen($digits) === 11) {
            return preg_replace('/(\d{2})(\d)(\d{4})(\d{4})/', '($1) $2$3-$4', $digits);
        }

        if (strlen($digits) === 10) {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $digits);
        }

        return $value ?? '';
    };
    $cpfValue = $formatCpf(old('cpf', optional($cliente)->cpf));
    $telefoneValue = $formatPhone(old('telefone', optional($cliente)->telefone));
@endphp

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome"
            value="{{ old('nome', optional($cliente)->nome) }}" required maxlength="45">
    </div>
    <div class="col-md-3 mb-3">
        <label for="cpf" class="form-label">CPF</label>
        <input type="text" class="form-control" id="cpf" name="cpf"
            value="{{ $cpfValue }}" required maxlength="14" placeholder="000.000.000-00"
            pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" title="Informe o CPF no formato 000.000.000-00">
    </div>
    <div class="col-md-3 mb-3">
        <label for="telefone" class="form-label">Telefone</label>
        <input type="text" class="form-control" id="telefone" name="telefone"
            value="{{ $telefoneValue }}" required maxlength="15" placeholder="(00) 00000-0000"
            pattern="\(\d{2}\)\s?\d{4,5}-\d{4}" title="Informe o telefone no formato (00) 00000-0000">
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email"
            value="{{ old('email', optional($cliente)->email) }}" required maxlength="255">
    </div>
    <div class="col-md-4 mb-3">
        <label for="sexo" class="form-label">Sexo</label>
        <select class="form-control" id="sexo" name="sexo" required>
            @php
                $sexoAtual = old('sexo', optional($cliente)->sexo);
            @endphp
            <option value="" disabled {{ $sexoAtual ? '' : 'selected' }}>Selecione</option>
            <option value="Feminino" {{ $sexoAtual === 'Feminino' ? 'selected' : '' }}>Feminino</option>
            <option value="Masculino" {{ $sexoAtual === 'Masculino' ? 'selected' : '' }}>Masculino</option>
            <option value="Outro" {{ $sexoAtual === 'Outro' ? 'selected' : '' }}>Outro</option>
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label for="nascimento" class="form-label">Data de Nascimento</label>
        <input type="date" class="form-control" id="nascimento" name="nascimento"
            value="{{ $nascimentoValue }}" required>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="estadoCivil" class="form-label">Estado Civil</label>
        <select class="form-control" id="estadoCivil" name="estadoCivil" required>
            @php
                $estadoCivilAtual = old('estadoCivil', optional($cliente)->estadoCivil);
            @endphp
            <option value="" disabled {{ $estadoCivilAtual ? '' : 'selected' }}>Selecione</option>
            <option value="Solteiro(a)" {{ $estadoCivilAtual === 'Solteiro(a)' ? 'selected' : '' }}>Solteiro(a)</option>
            <option value="Casado(a)" {{ $estadoCivilAtual === 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
            <option value="Divorciado(a)" {{ $estadoCivilAtual === 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)</option>
            <option value="Viuvo(a)" {{ $estadoCivilAtual === 'Viuvo(a)' ? 'selected' : '' }}>Viuvo(a)</option>
            <option value="Outro" {{ $estadoCivilAtual === 'Outro' ? 'selected' : '' }}>Outro</option>
        </select>
    </div>
    <div class="col-md-8 mb-3">
        <label for="endereco" class="form-label">Endereco</label>
        <input type="text" class="form-control" id="endereco" name="endereco"
            value="{{ old('endereco', optional($cliente)->endereco) }}" required maxlength="100">
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="cidade" class="form-label">Cidade</label>
        <input type="text" class="form-control" id="cidade" name="cidade"
            value="{{ old('cidade', optional($cliente)->cidade) }}" required maxlength="50">
    </div>
    <div class="col-md-6 mb-3">
        <label for="estado" class="form-label">Estado</label>
        <input type="text" class="form-control" id="estado" name="estado"
            value="{{ old('estado', optional($cliente)->estado) }}" required maxlength="50">
    </div>
</div>

<div class="d-flex justify-content-end">
    <a href="{{ route('clientes.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
    <button type="submit" class="btn btn-primary">
        {{ isset($cliente) ? 'Salvar alteracoes' : 'Cadastrar Cliente' }}
    </button>
</div>

<script>
    (function () {
        if (window.__clientesFormMaskInitialized) {
            return;
        }

        window.__clientesFormMaskInitialized = true;

        function formatCpf(value) {
            const digits = value.replace(/\D/g, '').slice(0, 11);

            if (digits.length <= 3) {
                return digits;
            }
            if (digits.length <= 6) {
                return digits.slice(0, 3) + '.' + digits.slice(3);
            }
            if (digits.length <= 9) {
                return (
                    digits.slice(0, 3) +
                    '.' +
                    digits.slice(3, 6) +
                    '.' +
                    digits.slice(6)
                );
            }

            return (
                digits.slice(0, 3) +
                '.' +
                digits.slice(3, 6) +
                '.' +
                digits.slice(6, 9) +
                '-' +
                digits.slice(9, 11)
            );
        }

        function formatPhone(value) {
            const digits = value.replace(/\D/g, '').slice(0, 11);

            if (digits.length === 0) {
                return '';
            }
            if (digits.length <= 2) {
                return '(' + digits;
            }
            if (digits.length <= 6) {
                return '(' + digits.slice(0, 2) + ') ' + digits.slice(2);
            }
            if (digits.length <= 10) {
                return (
                    '(' +
                    digits.slice(0, 2) +
                    ') ' +
                    digits.slice(2, 6) +
                    '-' +
                    digits.slice(6)
                );
            }

            return (
                '(' +
                digits.slice(0, 2) +
                ') ' +
                digits.slice(2, 7) +
                '-' +
                digits.slice(7, 11)
            );
        }

        function applyMask(input, formatter) {
            if (!input) {
                return;
            }

            input.value = formatter(input.value);
            input.addEventListener('input', function () {
                this.value = formatter(this.value);
            });
        }

        const cpfField = document.getElementById('cpf');
        const telefoneField = document.getElementById('telefone');

        applyMask(cpfField, formatCpf);
        applyMask(telefoneField, formatPhone);

        function initMasks() {
            applyCpfMask(document.getElementById('cpf'));
            applyPhoneMask(document.getElementById('telefone'));
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initMasks);
        } else {
            initMasks();
        }
    })();
</script>
