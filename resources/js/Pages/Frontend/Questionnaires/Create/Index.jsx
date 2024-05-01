import FrontendLayout from "@/Layouts/Frontend/Layout";
import { Head, useForm } from "@inertiajs/react";
import PrimaryButton from "@/Components/PrimaryButton";
import { useCallback } from "react";

export default function TakeExam({ auth, questionnaire, questions, status }) {
  const { data, setData, post, processing, errors, reset } = useForm({
    answers: "",
  });

  const handleSubmit = useCallback(
    (e) => {
      e.preventDefault();

      post(route("check-exam", questionnaire));
    },
    [post, questionnaire]
  );

  const handleChange = useCallback(
    (questionId, value) => {
      setData("answers", {
        ...data.answers,
        [questionId]: value,
      });
    },
    [setData]
  );

  return (
    <FrontendLayout user={auth.user}>
      <Head title={`Exam: ${questionnaire.title}`} />

      <div className="grid gap-0 lg:grid-cols-1 lg:gap-8 mb-3 select-none">
        <div className="flex flex-col items-center gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
          <div className="w-full">
            <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
              {questionnaire.title}
            </h2>
          </div>
        </div>
      </div>

      <form onSubmit={handleSubmit} className="select-none">
        {questions.map((question, index) => (
          <div key={index} className="grid gap-0 lg:grid-cols-1 lg:gap-8 mb-3">
            <div className="flex flex-col items-center gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
              <div className="w-full">
                <div className="mt-4">
                  <h3 className="text-lg font-medium text-gray-900 dark:text-white">
                    {`${index + 1}.)`} {question.question}
                  </h3>
                  <div className="mt-3">
                    {question.choices.map((choice, choiceIndex) => (
                      <div key={choiceIndex} className="mt-2">
                        <label>
                          <input
                            type="radio"
                            name={`question_${index}`}
                            value={choiceIndex}
                            className="accent-[#FF2D20] focus:ring-[#FF2D20]"
                            onChange={(e) =>
                              handleChange(question.id, e.target.value)
                            }
                          />
                          <span className="ml-2 text-gray-600 dark:text-gray-300">
                            {choice}
                          </span>
                        </label>
                      </div>
                    ))}
                  </div>
                </div>
              </div>
            </div>
          </div>
        ))}

        <div className="flex items-center justify-end mt-4 mb-5">
          <PrimaryButton className="ml-4" disabled={processing}>
            Submit
          </PrimaryButton>
        </div>
      </form>
    </FrontendLayout>
  );
}
