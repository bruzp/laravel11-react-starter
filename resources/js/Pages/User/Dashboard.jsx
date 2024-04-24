import AuthenticatedLayout from "@/Layouts/User/AuthenticatedLayout";
import { Head } from "@inertiajs/react";

export default function Dashboard({ auth, rank }) {
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          My Dashboard
        </h2>
      }
    >
      <Head title="Dashboard" />

      <div className="py-12">
        <div className="max-w-full mx-auto sm:px-6 lg:px-8">
          <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900 dark:text-gray-100">
              {rank ? (
                <p>
                  You are currently ranked as <strong>{rank.rank_text}</strong>{" "}
                  overall—a fantastic achievement! Your highest score so far is
                  an impressive <strong>{rank.max_result}%</strong>. Keep up the
                  great work!
                </p>
              ) : (
                <p>
                  It looks like you haven't taken any exams yet. This is a great
                  opportunity to start your journey and see what you can
                  achieve! When you're ready, take your first exam, and begin
                  unlocking your potential. We're excited to see how far you can
                  go!
                </p>
              )}
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
