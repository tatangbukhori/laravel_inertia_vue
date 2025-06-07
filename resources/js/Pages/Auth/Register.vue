<script setup>

    import { useForm } from '@inertiajs/vue3';
    import TextInput from '../Components/TextInput.vue';

    const form = useForm({
        name: null,
        email: null,
        password: null,
        password_confirmation: null,
    });

    const submit =() => {
        form.post(route('register'), {
            onError: () => form.reset('password', 'password_confirmation'),
        });
    };

</script>

<template>
    <Head title="Register" />

    <h1 class="title">Register a new account</h1>

    <div class="w-2/4 mx-auto">
        <form @submit.prevent="submit">
            <!-- Text Input Name -->
            <TextInput name="name" v-model="form.name" :message="form.errors.name" />
            <!-- Text Input Email -->
            <TextInput name="email" type="email" v-model="form.email" :message="form.errors.email" />
            <!-- Text Input Password -->
            <TextInput name="password" type="password" v-model="form.password" :message="form.errors.password" />
            <!-- Text Input Confirm Password -->
            <TextInput name="confirm password" type="password" v-model="form.password_confirmation" />
            <div>
                <p class="text-slate-600 mb-2">Already a user? <a href="#" class="text-link">Login</a></p>
                <button class="primary-btn">Register</button>
            </div>
        </form>
    </div>
</template>