import AuthenticatedLayout from "@/Layouts/Admin/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import QuestionsList from "./Partials/Questions/QuestionsList";
import QuestionnaireEditForm from "./Partials/QuestionnaireEditForm";

export default function QuestionnaireEdit({
  auth,
  questionnaire,
  status,
  question_status,
}) {
  return (
    <AuthenticatedLayout
      admin={auth.admin}
      header={
        <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          Edit Questionnaire
        </h2>
      }
    >
      <Head title="Admin Edit Questionnaire" />

      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
          <div className="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <QuestionnaireEditForm
              className="max-w-full"
              questionnaire={questionnaire}
              status={status}
            />
          </div>

          <div className="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <QuestionsList
              className="max-w-full"
              questionnaire={questionnaire}
              status={question_status}
            />
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
