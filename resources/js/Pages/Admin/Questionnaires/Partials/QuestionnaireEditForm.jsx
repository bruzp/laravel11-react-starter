export default function QuestionsList({ className = "", status }) {
  return (
    <section className={className}>
      <header>
        <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">
          Edit Questionnaire
        </h2>
      </header>

      <div className="flex flex-col">
        <div className="overflow-x-auto">
          <div className="pl-5 pr-5 w-full inline-block align-middle">
            {status && (
              <div className="mb-4 font-medium text-sm text-green-600">
                {status}
              </div>
            )}

            <form onSubmit={handleSubmit}>
              <div className="mb-5">
                <InputLabel htmlFor="title" value="Name" />

                <TextInput
                  id="title"
                  name="title"
                  value={data.title}
                  className="mt-1 block w-full"
                  autoComplete="off"
                  isFocused={true}
                  onChange={handleOnChange}
                />

                <InputError message={errors.title} className="mt-2" />
              </div>

              <div className="mb-5">
                <InputLabel htmlFor="description" value="Description" />

                <TextAreaInput
                  id="description"
                  name="description"
                  value={data.description}
                  className="mt-1 block w-full"
                  autoComplete="off"
                  onChange={handleOnChange}
                />

                <InputError message={errors.description} className="mt-2" />
              </div>

              <div className="flex items-center justify-end mt-4 mb-5">
                <PrimaryButton className="ml-4" disabled={processing}>
                  Submit
                </PrimaryButton>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  );
}
